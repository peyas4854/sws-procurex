<template>
    <div>
        <div class="modal fade" tabindex="-1" role="dialog" id="purchase_order_detail_modal">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">PO Item List</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive p-2">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" class="checkbox" v-model="allSelected"
                                               @change="selectAll"/>
                                    </th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Item Detail Description</th>
                                    <th scope="col" data-toggle="tooltip" data-placement="top"
                                        title="Request Quantity">Reqd. Qty
                                    </th>
                                    <th scope="col">UoM</th>
                                    <th scope="col"> Unit Price</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col">VAT</th>
                                    <th scope="col">Vat Amount</th>
                                    <th scope="col">Total Price (incl. VAT)</th>

                                </tr>
                                </thead>
                                <tbody>

                                <tr v-for="(product,index) in itemList">
                                    <td>
                                        <input type='checkbox' v-model="loadItems" :value="product"
                                               @change='updateCheckall()' :disabled="product.quantity == 0">
                                    </td>
                                    <td> {{ product.category }}</td>
                                    <td> {{ product.item_name }}</td>
                                    <td> {{ product.description ? product.description : '' }}</td>
                                    <td> {{ product.quantity }}</td>
                                    <td> {{ product.uom }}</td>
                                    <td> {{ product.unit_price }}</td>
                                    <td> {{ product.total_price_without_vat }}</td>
                                    <td> {{ product.vat }} %</td>
                                    <td> {{ product.vat_amount }}</td>
                                    <td> {{ product.total_price_with_vat }}</td>

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
    name: "PurchaseOrderDetailModal",
    props: ['poId'],
    data() {
        return {
            itemList: [],
            allSelected: false,
            loadItems: [],
        }
    },
    mounted() {
        this.openModal();
    },
    methods: {
        openModal() {
            $('#purchase_order_detail_modal').modal('show');
            this.getItem();

        },
        closeModal() {
            $('#purchase_order_detail_modal').modal('hide');
            this.$emit('closedModal', 'yes')
        },
        getItem() {
            axios.get(`/purchase-order-detail/${this.poId}`)
                .then((response) => {
                    console.log('data', response.data.data);
                    this.itemList = response.data.data;
                }).catch((error) => {
                console.log(error)
            })
        },
        async selectAll() {
            if (this.allSelected) {
                const selected = this.itemList.filter((u) => u.quantity !=0);
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
        loadItem() {
            this.$emit('load-item', this.loadItems);
            this.closeModal();
        },


    }
}
</script>

<style scoped>

</style>
