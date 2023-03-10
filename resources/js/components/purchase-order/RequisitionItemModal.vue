<template>
    <div>
        <div class="modal fade" tabindex="-1" role="dialog" id="requisition-item-modal">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pr Item List</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive p-1">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th><input type="checkbox" class="checkbox" v-model="allSelected" @change="selectAll"/>
                                </th>

                                <th>PR code</th>
                                <th>Name</th>
                                <th data-toggle="tooltip" data-placement="top"
                                    title="Description/Specification">Desc/Spec
                                </th>
                                <th>Brand/Model</th>
                                <th>Quantity</th>
                                <th>UoM</th>
                                <th data-toggle="tooltip" data-placement="top"
                                    title="Latest Unit Price">LUP
                                </th>
                                <th>Total Price</th>

                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="(product, index) in itemList">
                                <td>
                                    <input type='checkbox' v-model="loadItems" :value="product"
                                           @change='updateCheckall()'>
                                </td>

                                <td>{{ product.requisition_code }}</td>
                                <td>{{ product.item  }}</td>
                                <td>{{ product.description ? product.description : ' ' }}</td>
                                <td>{{ product.brand ? product.brand : ' ' }}</td>
                                <td>{{ product.quantity ? product.quantity : ' ' }}</td>
                                <td>{{ product.uom ? product.uom : ' ' }}</td>
                                <td>{{ numberFormat(product.unit_price) }}</td>
                                <td>{{ numberFormat(product.total_price_without_vat) }}</td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="loadItem">Load Item</button>
                        <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "RequisitionItemModal",
    props: {
        requisition_ids: {
            type: Array,
            required: false
        }
    },
    data: () => ({
        itemList: [],
        loadItems: [],
        allSelected: false,

    }),
    mounted() {
        this.openModal();
        console.log('modal open', this.requisition_ids);
    },
    methods: {
        openModal() {
            $('#requisition-item-modal').modal('show');
            this.getRequisitionItems();
        },
        closeModal() {
            $('#requisition-item-modal').modal('hide');
            this.$emit('closedModal', 'yes')
        },
        getRequisitionItems() {
            console.log('ids', typeof (this.requisition_ids));
            let params = {
                ids: this.requisition_ids
            };
            axios.post(`/requisition-item`, params)
                .then((response) => {
                    console.log('response', response.data.data);
                    this.itemList = response.data.data;
                }).catch((error) => {
                console.log(error);
            })
        },
        async selectAll() {
            if (this.allSelected) {
                const selected = this.itemList.map((u) => u);
                console.log('all selected', selected);
                this.loadItems = selected;
            } else {
                console.log('else');
                this.loadItems = [];
            }
        },
        updateCheckall() {
            if (this.itemList.length == this.loadItems.length) {
                this.allSelected = true;
            } else {
                this.allSelected = false;
            }
        },
        loadItem(){
            this.$emit('load-item',this.loadItems);
            this.closeModal();
        },
        numberFormat(value) {
            return Number.parseFloat(value).toFixed(2);
        },
    }
}
</script>

