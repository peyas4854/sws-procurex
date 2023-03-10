<template>
<div>
    <div class='alert alert-success mb-2' v-if="showAlert">
        <button type='button' class='close' data-dismiss='alert'>
            <span aria-hidden='true'>×</span>
            <span class='sr-only'>Close</span>
        </button>
        <i class='bx bxs-check-circle'></i> {{ message }}
    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body pb-0 mx-25">
                        <div class="row invoice-info">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="employee">PO Select</label>
                                    <select v-model="poId" class="form-control">
                                        <option disabled selected>Please select item type</option>
                                        <option v-for="(poDetail,index) in poList" :value="poDetail.id">
                                            {{ poDetail.po_code }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 my-auto">
                                <div class="form-group my-auto">
                                    <button class="btn btn-sm btn-primary"
                                            :disabled="poId.length == 0"
                                            @click="loadPOItem"
                                    > Load PO Item</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-50">
                        <div class="invoice-product-details">
                            <div class="table-responsive p-1">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">SL #</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col" data-toggle="tooltip" data-placement="top"
                                            title="Request Quantity">Received Qty
                                        </th>
                                        <th> Comment </th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr v-for="(product,index) in grnForm.items">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ product.item_name ?product.item_name :''  }}</td>
                                        <td>
                                            <input type="number" class="from-control" v-model="product.quantity">
                                        </td>
                                        <td>
                                            <textarea v-model="product.comment"></textarea>
                                        </td>
                                        <td>
                                            <a class="btn btn-icon btn-danger btn-sm glow mr-1 mb-1 text-white cursor-pointer"
                                               @click="deleteItem(product)" :disabled="grnForm.items.length ==1"
                                            ><i class="bx bx-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <hr>
                        <div class="invoice-subtotal pt-50">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="card invoice-action-wrapper shadow-none border">
                                    <div class="card-body">
                                        <h4>Attachments</h4>
                                        <file-upload @file-handle="filehandle"/>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-5">
                                <div class="invoice-action-btn mt-1">
                                    <button class="btn btn-primary btn-block invoice-send-btn" @click="saveGrn"
                                    :disabled="grnForm.items.length == 0"
                                    >
                                        <i class="bx bx-send"></i>
                                        <span>Send GRN</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <PurchaseOrderDetailModal
        v-if="poModal"
        @close="poModal=false"
        :poId="poId"
        @load-item="loadItem"
    >
    </PurchaseOrderDetailModal>

</div>
</template>
<script>
import PurchaseOrderDetailModal from "./PurchaseOrderDetailModal";
export default {
    name: "Form",
    data: () => ({
        poList:[],
        poId:'',
        poModal:false,
        grnForm:{
            items:[],
        },
        files:[],
        showAlert: false,
        message: '',
        loader: true,

    }),
    components:{
        PurchaseOrderDetailModal
    },
    mounted(){
        this.getPoList();
    },
    watch: {
        poId(newVal, oldVal) {
            if (oldVal) {
                if (confirm("After change item type form will be empty . Are you sure want to change?")) {
                    console.log('yes');
                    this.grnForm.items = [];
                }else{
                    console.log('no');
                }
            }
        }
    },
    methods:{
        getPoList(){
            axios.get('/purchase-order/approved')
                .then((response) => {
                    this.poList = response.data;
                }).catch((error) => {
                console.log(error)
            })
        },

        loadPOItem(){
            if(this.poId){
                this.poModal = !this.poModal;
            }
        },
        loadItem(loadPOItems){
            console.log('loadPOItems',loadPOItems);
            this.grnForm.items = loadPOItems;
        },
        deleteItem(product) {
            if (this.grnForm.items.length == 1) {
                return;
            }
            let index = this.grnForm.items.findIndex(e => e === product);
            this.grnForm.items.splice(index, 1);
        },
        saveGrn(){
            console.log('items',this.grnForm.items);
            let formData = new FormData();
            formData.append('items', JSON.stringify(this.grnForm.items));
            this.files.forEach((files, index) => {
                formData.append(`files[${index}]`, files);
            })

            axios.post('/grn-store',formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                console.log('response', response.data);
                this.message = response.data.message;
                this.showAlert = true;
                window.location.href = window.APP_URL + '/grn';
            }).catch((error) => {
                console.log('error', error);
            })
        },
        filehandle(files) {
            this.files = files;
        },
    }
}
</script>

