(function ( $ ) {
    'use strict';
    $ ( function () {


        $ ( '#setting-page-container' ).on ( 'change', 'select.adding-type-field', function () {
            var $optionValue = $ ( this ).val ();

            switch ( $optionValue ) {
                case "dropdown":
                case "radio":
                case "check":
                    // get the current element dom counter
                    var $counter = $ ( this ).nextAll ().length;
                    // get the current section for the all element counter
                    var $counterContainer = $ ( this ).parents ( '.woocommerce-extra-fields-container' ).find ( '.wooextra-section-container' ).length;

                    // adding the html for the current dropdown and radio
                    $ ( this ).parents ( '.wooextra-section-container' ).find ( 'td:first' ).append ( '' +
                    '<div class="adding-dropdown-extra-fields">' +
                    '<input type="text" class="extra-dropdown-fields-label" value="" placeholder="Label" name="woocommerce_extra_fields_setting_name[' + ($counterContainer - 1) + '][' + $counter + '][woocommerce_extra_fields_setting_name_label]">' +
                    '<input type="text" class="extra-dropdown-fields-value" value="" placeholder="Value" name="woocommerce_extra_fields_setting_name[' + ($counterContainer - 1) + '][' + $counter + '][woocommerce_extra_fields_setting_name_value]">' +
                    '<a href="" class="boxclose"><i class="fa fa-close"></i></a>' +
                    '<a href="" class="boxadd"><i class="fa fa-plus"></i></a>' +
                    '</div>' );
                    break;
                default :
                    $ ( this ).nextAll ( '.adding-dropdown-extra-fields' ).remove ();   // remove the dropdown elements if dropdown is not selected

            }


        } ).on ( 'click', '#add-more-fields', function () {

            // when the user use the add button to add new fields
            var $containerToClone = $ ( this ).parents ( '#setting-page-container' ).find ( '.wooextra-section-container:first' ).clone ( true, true );

            // Reset the cloned data
            $containerToClone.find ( 'option' ).each ( function ( index, element ) {
                $ ( element ).removeAttr ( 'selected' );
            } );
            $containerToClone.find ( 'input:text' ).each ( function ( index, element ) {
                $ ( element ).val ( '' );   // resset the value of the input
            } );
            // End resetting the data

            // increase the name of the added fields using regular expression
            $containerToClone.find ( '[name]' ).each ( function ( index, element ) {
                var $allElementName = $ ( element ).attr ( 'name' );              // Got all the elements names for the inputs
                // get the current section for the all element counter
                var $counterContainer = $ ( '.wooextra-section-container' ).length;

                var $name = $allElementName.replace ( /\[[^\]]+\]/, "[" + $counterContainer + "]" );
                $ ( element ).attr ( 'name', $name );

            } );
            // remove the extra dropdown fields ( if they are there )
            $containerToClone.find ( '.adding-dropdown-extra-fields' ).remove ();

            // adding the cloned
            $ ( this ).parents ( '#setting-page-container' ).find ( '#sortable' ).append ( $containerToClone );

            // refresh the fields for sortable
            //$ ( "#sortable" ).sortable ( 'refresh' );

        } ).on ( 'click', '.boxadd', function ( e ) {
            e.preventDefault ();
            var $boxAddButton = $ ( this );
            var $clonedRow = $boxAddButton.parents ( 'td' ).find ( '.adding-dropdown-extra-fields' ).first ().clone ();
            // this for the second bracket
            var $extraDropDownFieldsCount = $ ( this ).parents ( 'td' ).find ( '.adding-dropdown-extra-fields' ).length;
            // increase the name of the added fields using regular expression
            $clonedRow.find ( '[name]' ).each ( function ( index, element ) {
                var $allElementName = $ ( element ).attr ( 'name' );              // Got all the elements names for the inputs
                var $name = $allElementName.replace ( /([^\[\]]+)(?=\]\[[^\]]+\]$)/, $extraDropDownFieldsCount );
                $ ( element ).attr ( 'name', $name );
                $ ( element ).val ( '' );
            } );
            $boxAddButton.parents ( 'td' ).append ( $clonedRow );            // add the cloned row

        } ).on ( 'click', '.boxclose', function ( e ) {
            e.preventDefault ();
            var $this = $ ( this );
            $this.parent ().remove ();

        } ).on ( 'click', '.containerclose', function ( e ) {
            e.preventDefault ();
            $ ( this ).parents ( '.wooextra-section-container' ).slideUp ( 400, function () {
                $ ( this ).remove ();   // then remove
            } )
        } );



        //$ ( "#sortable" ).sortable ( {
        //    update: function ( e, ui ) {
        //        var $currentItemIndex = ui.item.index ();
        //        var $allContainers = ui.item.parent ( '#sortable' ).find ( '.wooextra-section-container' );
        //
        //        $allContainers.each ( function ( index, element ) {
        //            var $element = $ ( element ).find ( '[name]' );
        //            var $name = $element.attr ( 'name' ).replace ( /([^\[\]]+)(?=\]\[[^\]]+\]$)/, index );
        //            $ ( element ).attr ( 'name', $name );
        //
        //            $.each ( $element, function ( index, element ) {
        //                var $element = $ ( element ).find ( '[name]' );
        //                var $name = $element.attr ( 'name' );
        //                console.log($ ( element ).find ( 'input' ).attr('name'));
        //                $ ( element ).attr ( 'name', $name );
        //            } )
        //        } );
        //    }
        //
        //} );

    } );
}) ( jQuery );