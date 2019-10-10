/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'underscore',
    'uiRegistry',
    'Magento_Ui/js/form/element/select'
], function (_, uiRegistry, select) {
    'use strict';

    return select.extend({

        /**
         * Hide fields on status tab
         */
        onUpdate: function () {
            this.enableDisableFields();
        },

        /**
         * Enable/disable fields
         */
        enableDisableFields: function () {
            var promoteStatus,
                retailerList;

            // retailerList = uiRegistry
            //     .get('smile_retailer_promotion_form_create.smile_retailer_promotion_form_create.general.retailer_id');
            retailerList = document.getElementsByClassName('retailer-list-id')[0];
            retailerList.style.display = 'block';

            promoteStatus = uiRegistry
                .get('smile_retailer_promotion_form_create.smile_retailer_promotion_form_create.general.status')
                .value();
            if (promoteStatus == 2) {
                retailerList.style.display = 'none';
            }
        }
    });
});
