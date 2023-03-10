export default{
    data: () => ({
            sampleItem: {
                category_id: null,
                quantity: null,
                uom_id: null,
                item_id:'',
                unit_price: null,
                total_price_without_vat: 0,
                vat: 0.00,
                vat_amount:0,
                total_price_with_vat: 0,
                description: null,

            },
            editorConfig: {
                // The configuration of the editor.
                toolbar: [{ name: 'basicstyles', groups: [ 'basicstyles' ], items: [ 'Bold', 'Italic', 'Underline' ] },
                    { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
                    { name: 'scripts', items: [ 'Subscript', 'Superscript' ] },
                    { name: 'justify', groups: [ 'blocks', 'align' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
                    { name: 'paragraph', groups: [ 'list' ], items: [ 'NumberedList', 'BulletedList','JustifyLeft','JustifyCenter','JustifyRight'] },                    { name: 'spell', items: [ 'jQuerySpellChecker' ] },
                    { name: 'table', items: [ 'Table' ] }
                ],
            }
    }),
    filters:{
        numberFormat(value) {
            return Number.parseFloat(value).toFixed(2);
        },
    },
    methods:{
        numberFormat(value) {
            return Number.parseFloat(value).toFixed(2);
        },
        setQuantity(quantity) {
            if (quantity) {
                return quantity == 0 ? 1 : quantity;
            } else {
                return 1;
            }
        },
        checkIsNan(value){
            return isNaN(value) == true ? 0 : this.numberFormat(value);
        },
        subTotal() {
            let total_price_without_vat = this.purchaseOrderItem.map(e => Number(e.total_price_without_vat)).reduce((prev, next) => prev + next);
            this.purchaseOrderForm.total_price_without_vat = this.checkIsNan(total_price_without_vat);
            let total_price_with_vat = this.purchaseOrderItem.map(e => Number(e.total_price_with_vat)).reduce((prev, next) => prev + next);
            this.purchaseOrderForm.total_price_with_vat = this.checkIsNan(total_price_with_vat);
        },
    },

}
