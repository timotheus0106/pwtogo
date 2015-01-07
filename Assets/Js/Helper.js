define([
    'jquery',
], function(
    $
) {
    'use strict';

    var module = {

        ajax: function(action, ajaxData, responseFunction) {

            ajaxData.action = action;

            $.ajax({

                type: 'POST',
                data: ajaxData

            }).done(function(response) {

                responseFunction(response);

            }).fail(function(xhr, ajaxOptions, thrownError) {

                alert(thrownError);

            });

        }
    };
    return module;
});