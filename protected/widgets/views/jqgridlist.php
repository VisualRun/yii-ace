<div class="col-xs-12">
  <table id="grid-table"></table>

  <div id="grid-pager"></div>

  <script type="text/javascript">
      var $path_base = "..";//this will be used for editurl parameter
    </script>

  <!-- PAGE CONTENT ENDS -->
</div>
<!-- /.col -->

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
      jQuery(function($) {
        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        //resize to fit page size
        $(window).on('resize.jqGrid', function () {
          $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
        })
        //resize on sidebar collapse/expand
        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
          if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
            $(grid_selector).jqGrid( 'setGridWidth', parent_column.width() );
          }
        })

        var gridSettings = <?php echo $gridSettings ?>;

        gridSettings['loadComplete'] = function() {
            var table = this;
            setTimeout(function(){
              styleCheckbox(table);

              updateActionIcons(table);
              updatePagerIcons(table);
              enableTooltips(table);
            }, 0);
          };

        jQuery(grid_selector).jqGrid(gridSettings);
        $(window).triggerHandler('resize.jqGrid');//trigger window resize to make the grid get the correct size

        //enable search/filter toolbar
        //jQuery(grid_selector).jqGrid('filterToolbar',{defaultSearch:true,stringResult:true})
        //jQuery(grid_selector).filterToolbar({});


        //switch element when editing inline
        function aceSwitch( cellvalue, options, cell ) {
          setTimeout(function(){
            $(cell) .find('input[type=checkbox]')
              .addClass('ace ace-switch ace-switch-5')
              .after('<span class="lbl"></span>');
          }, 0);
        }
        //enable datepicker
        function pickDate( cellvalue, options, cell ) {
          setTimeout(function(){
            $(cell) .find('input[type=text]')
                .datepicker({format:'yyyy-mm-dd' , autoclose:true});
          }, 0);
        }


        //navButtons
        var pagerSettings = [<?php echo $pagerSettings ?>];
        //console.log(pagerSettings);
        pagerSettings[1]['beforeShowForm'] = function(e) {
              var form = $(e[0]);
              form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
              style_edit_form(form);
            };
        pagerSettings[2]['beforeShowForm'] = function(e) {
              var form = $(e[0]);
              form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
              .wrapInner('<div class="widget-header" />')
              style_edit_form(form);
            };
        pagerSettings[3]['beforeShowForm'] = function(e) {
              var form = $(e[0]);
              if(form.data('styled')) return false;

              form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
              style_delete_form(form);

              form.data('styled', true);
            };
        pagerSettings[4]['afterShowSearch'] = function(e){
              var form = $(e[0]);
              form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
              style_search_form(form);
            };
        pagerSettings[4]['afterRedraw'] = function(){
              style_search_filters($(this));
            };
        // pagerSettings[6]['beforeShowForm'] = function(e){
        //       var form = $(e[0]);
        //       form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
        //     };
        //console.log(pagerSettings)
        jQuery(grid_selector).jqGrid('navGrid',pager_selector,pagerSettings[0],pagerSettings[1],pagerSettings[2],pagerSettings[3],pagerSettings[4],pagerSettings[5],pagerSettings[6])



        function style_edit_form(form) {
          //enable datepicker on "sdate" field and switches for "stock" field
          form.find('input[name=sdate]').datepicker({format:'yyyy-mm-dd' , autoclose:true})
            .end().find('input[name=stock]')
              .addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');
                 //don't wrap inside a label element, the checkbox value won't be submitted (POST'ed)
                //.addClass('ace ace-switch ace-switch-5').wrap('<label class="inline" />').after('<span class="lbl"></span>');

          //update buttons classes
          var buttons = form.next().find('.EditButton .fm-button');
          buttons.addClass('btn btn-sm').find('[class*="-icon"]').hide();//ui-icon, s-icon
          buttons.eq(0).addClass('btn-primary').prepend('<i class="ace-icon fa fa-check"></i>');
          buttons.eq(1).prepend('<i class="ace-icon fa fa-times"></i>')

          buttons = form.next().find('.navButton a');
          buttons.find('.ui-icon').hide();
          buttons.eq(0).append('<i class="ace-icon fa fa-chevron-left"></i>');
          buttons.eq(1).append('<i class="ace-icon fa fa-chevron-right"></i>');
        }

        function style_delete_form(form) {
          var buttons = form.next().find('.EditButton .fm-button');
          buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
          buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-trash-o"></i>');
          buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
        }

        function style_search_filters(form) {
          form.find('.delete-rule').val('X');
          form.find('.add-rule').addClass('btn btn-xs btn-primary');
          form.find('.add-group').addClass('btn btn-xs btn-success');
          form.find('.delete-group').addClass('btn btn-xs btn-danger');
        }
        function style_search_form(form) {
          var dialog = form.closest('.ui-jqdialog');
          var buttons = dialog.find('.EditTable')
          buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
          buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
          buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
        }

        function beforeDeleteCallback(e) {
          var form = $(e[0]);
          if(form.data('styled')) return false;

          form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
          style_delete_form(form);

          form.data('styled', true);
        }

        function beforeEditCallback(e) {
          var form = $(e[0]);
          form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
          style_edit_form(form);
        }



        //it causes some flicker when reloading or navigating grid
        //it may be possible to have some custom formatter to do this as the grid is being created to prevent this
        //or go back to default browser checkbox styles for the grid
        function styleCheckbox(table) {
        /**
          $(table).find('input:checkbox').addClass('ace')
          .wrap('<label />')
          .after('<span class="lbl align-top" />')


          $('.ui-jqgrid-labels th[id*="_cb"]:first-child')
          .find('input.cbox[type=checkbox]').addClass('ace')
          .wrap('<label />').after('<span class="lbl align-top" />');
        */
        }


        //unlike navButtons icons, action icons in rows seem to be hard-coded
        //you can change them like this in here if you want
        function updateActionIcons(table) {
          /**
          var replacement =
          {
            'ui-ace-icon fa fa-pencil' : 'ace-icon fa fa-pencil blue',
            'ui-ace-icon fa fa-trash-o' : 'ace-icon fa fa-trash-o red',
            'ui-icon-disk' : 'ace-icon fa fa-check green',
            'ui-icon-cancel' : 'ace-icon fa fa-times red'
          };
          $(table).find('.ui-pg-div span.ui-icon').each(function(){
            var icon = $(this);
            var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
            if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
          })
          */
        }

        //replace icons with FontAwesome icons like above
        function updatePagerIcons(table) {
          var replacement =
          {
            'ui-icon-seek-first' : 'ace-icon fa fa-angle-double-left bigger-140',
            'ui-icon-seek-prev' : 'ace-icon fa fa-angle-left bigger-140',
            'ui-icon-seek-next' : 'ace-icon fa fa-angle-right bigger-140',
            'ui-icon-seek-end' : 'ace-icon fa fa-angle-double-right bigger-140'
          };
          $('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function(){
            var icon = $(this);
            var $class = $.trim(icon.attr('class').replace('ui-icon', ''));

            if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
          })
        }

        function enableTooltips(table) {
          $('.navtable .ui-pg-button').tooltip({container:'body'});
          $(table).find('.ui-pg-div').tooltip({container:'body'});
        }

        //var selr = jQuery(grid_selector).jqGrid('getGridParam','selrow');


      });
    </script>