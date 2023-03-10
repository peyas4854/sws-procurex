<template>
    <div>
        <div>
            <div class='alert alert-success mb-2' v-if="showAlert">
                <button type='button' class='close' data-dismiss='alert'>
                    <span aria-hidden='true'>×</span>
                    <span class='sr-only'>Close</span>
                </button>
                <i class='bx bxs-check-circle'></i> {{ message }}
            </div>
            <Loader v-if="loader"/>
            <div class="row" v-if="!loader">
                <div class="col-xl-12 col-md-12 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body pb-0 mx-25">
                                <!-- invoice address and contact -->
                                <div class="row invoice-info">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="employee">PO Creator </label>

                                            <input type="text" class="form-control" disabled
                                                    :value="purchaseOrder.employee_name">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="designation">ID No</label>
                                            <input type="text" class="form-control" readonly
                                                   :value="purchaseOrder.employee_id">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="department">Vendor Name </label>
                                            <v-select :options="purchaseOrder.vendorList"
                                                      v-model="purchaseOrderForm.vendor_id"
                                                      :reduce="(option) => option.id"
                                                      label="name"
                                            ></v-select>
                                            <span v-if="errors.vendor_id" class="text-danger"> {{
                                                    errors.vendor_id[0]
                                                }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="po_creation_date">PO Creation Date </label>
                                            <input type="text" readonly class="form-control"
                                                   v-model="purchaseOrder.application_date">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="delivery_location" class="d-block">Delivery location</label>
                                            <textarea rows="2" class="d-block" v-model="purchaseOrderForm.delivery_location"></textarea>
                                            <span v-if="errors.delivery_location" class="text-danger"> {{
                                                    errors.delivery_location[0]
                                                }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="delivery_date">Delivery Date </label> <br>
                                            <Datepicker v-model="purchaseOrderForm.delivery_date" id="datepicker"
                                                        input-class="date-picker-class"
                                            ></Datepicker>
                                        </div>
                                    </div>
                                    <div class="col-md-3">

                                        <div class="form-group">
                                            <label for="cost_center">Cost Center</label>
                                            <v-select :options="purchaseOrder.costCenterList"
                                                      v-model="purchaseOrderForm.cost_center_id"
                                                      :reduce="(option) => option.id"
                                                      label="name"
                                                      @input="changeCostCenter(purchaseOrderForm.cost_center_id)"
                                            ></v-select>
                                            <span v-if="errors.cost_center_id" class="text-danger"> {{
                                                    errors.cost_center_id[0]
                                                }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="procurement_type">Procurement Type </label>
                                            <select v-model="purchaseOrderForm.procurement_type" class="form-control">
                                                <option disabled selected>Please select one</option>
                                                <option v-for="(procurementType,index) in purchaseOrder.procurementType"
                                                        :value="index">{{ procurementType }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="budhet_info">Budget info</label>
                                            <select v-model="purchaseOrderForm.budget_info" class="form-control">
                                                <option disabled selected>Please select one</option>
                                                <option v-for="(budgetInfo,index) in purchaseOrder.budgetInfo"
                                                        :value="index">
                                                    {{ budgetInfo }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cost_center">Cs List</label>
                                            <v-select :options="purchaseOrder.csDetailList"
                                                      v-model="purchaseOrderForm.cs_detail"
                                                      :reduce="(option) => option.id"
                                                      multiple
                                                      label="cs_number"
                                            ></v-select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cost_center">PR List</label>
                                            <v-select :options="purchaseOrder.requisitionList"
                                                      v-model="purchaseOrderForm.requisition"
                                                      :reduce="(option) => option.id"
                                                      multiple
                                                      label="requisition_code"
                                            ></v-select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 my-auto">
                                        <div class="form-group my-auto">
                                            <button class="btn btn-sm btn-primary"
                                                    :disabled="purchaseOrderForm.requisition ==null "
                                                    @click="loadPRItem"
                                                    > Load PR Item</button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="card-body pt-50">
                                <!-- product details table-->
                                <div class="invoice-product-details ">
                                    <form class="form invoice-item-repeater">
                                        <div class="table-responsive p-1">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th scope="col">SL #</th>
                                                    <th scope="col">Category Name</th>
                                                    <th scope="col">Item Name</th>
                                                    <th scope="col">Item Detail Description</th>
                                                    <th scope="col" data-toggle="tooltip" data-placement="top"
                                                        title="Request Quantity" width="5px">Reqd. Qty
                                                    </th>
                                                    <th scope="col" width="5px">UoM</th>
                                                    <th scope="col"> Unit Price</th>
                                                    <th scope="col">Total Price</th>
                                                    <th scope="col">VAT</th>
                                                    <th scope="col">Vat Amount</th>
                                                    <th scope="col">Total Price (incl. VAT)</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(product, index) in purchaseOrderItem">
                                                    <td scope="row">
                                                        {{ index+1 }}
                                                    </td>
                                                    <td scope="row">

                                                        <input type="text" v-model="product.category_name" readonly
                                                               class="form-control" data-toggle="tooltip" data-placement="top"
                                                               :title="product.category_name">
                                                    </td>
                                                    <td>

                                                        <input type="text" v-model="product.item" readonly v-if="product.requisition_detail_id"
                                                               class="form-control" data-toggle="tooltip" data-placement="top"
                                                               :title="product.item">
                                                        <v-select :options="items"
                                                                  v-else
                                                                  :reduce="(option) => option.id"
                                                                  v-model="product.item_id"
                                                                  label="name"
                                                                  @input="changeItem(product,index)"
                                                        ></v-select>

                                                    </td>
                                                    <td>
                                                        <textarea v-model="product.description" class="form-control" data-toggle="tooltip" data-placement="top"
                                                                  :title="product.description"

                                                        ></textarea>

                                                    </td>
                                                    <td>
                                                        <input type="text" v-model="product.quantity" @keyup="changeItem(product,index,true)"
                                                               class="form-control" data-toggle="tooltip" data-placement="top"
                                                               :title="product.quantity"
                                                               style="width: 45px"

                                                        >
                                                    </td>

                                                    <td>
                                                        <input type="text" v-model="product.uom"
                                                               class="form-control " data-toggle="tooltip" data-placement="top"
                                                               :title="product.uom"
                                                        style="width:55px"
                                                        >
                                                    </td>
                                                    <td>

                                                        <input type="text" class="form-control"
                                                               v-model="product.unit_price" data-toggle="tooltip" data-placement="top"
                                                               :title="product.unit_price" @keyup="changeUnitPrice(product,index)">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                               v-model="product.total_price_without_vat"
                                                               readonly  data-toggle="tooltip" data-placement="top"
                                                               :title="product.total_price_without_vat">
                                                    </td>
                                                    <td>
                                                        <select v-model="product.vat" class="form-control" :disabled="product.item_id ==null" @change="vatSelect(product,index)">
                                                            <option disabled selected>Please select vat</option>
                                                            <option v-for="(vat,index) in purchaseOrder.vatList"
                                                                    :value="vat">{{ vat }}%
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                               v-model="product.vat_amount"
                                                               readonly data-toggle="tooltip" data-placement="top"
                                                               :title="product.vat_amount"
                                                               style="width:65px"

                                                        >
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                               v-model="product.total_price_with_vat"
                                                               readonly data-toggle="tooltip" data-placement="top"
                                                               :title="product.total_price_with_vat">
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-icon btn-danger btn-sm glow mr-1 mb-1 text-white cursor-pointer"
                                                           @click="deleteItem(product)" :disabled="purchaseOrderItem.length ==1"
                                                        ><i class="bx bx-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <span v-if="itemErrorMessage" class="text-danger"> {{itemErrorMessage }}</span>
                                        <div class="form-group">
                                            <div class="col p-0">
                                                <button class="btn btn-light-primary btn-sm" data-repeater-create
                                                        type="button" @click="addItem">
                                                    <i class="bx bx-plus"></i>
                                                    <span class="invoice-repeat-btn">Add Item</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <hr>
                                <div class="invoice-subtotal pt-50">
                                    <div class="row">
                                        <div class="col-md-7  col-12">
                                            <h4>Terms and Conditions </h4>
                                            <ckeditor v-model="editorData"
                                                      :config="editorConfig"></ckeditor>

                                        </div>
                                        <div class="col-md-5 col-12">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                                                    <span class="invoice-subtotal-title">Total Price </span>
                                                    <h6 class="invoice-subtotal-value mb-0">
                                                        {{ currency }} {{ purchaseOrderForm.total_price_without_vat }}</h6>
                                                </li>

                                                <li class="list-group-item py-0 border-0 mt-25">
                                                    <hr>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between border-0 py-0">
                                                    <span
                                                        class="invoice-subtotal-title"> Total Price(inc. VAT)</span>
                                                    <h6 class="invoice-subtotal-value mb-0">
                                                        {{ currency }} {{ purchaseOrderForm.total_price_with_vat }}</h6>
                                                </li>
                                            </ul>

                                            <div class="invoice-action-btn mt-1">
                                                <button class="btn btn-primary btn-block invoice-send-btn" @click="store">
                                                    <i class="bx bx-send"></i>
                                                    <span>Send Purchase Order(PO)</span>
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
        </div>
            <RequisitionItemModal v-if="requisitionModal"
                                  @closedModal="requisitionModal=false"
                                  :requisition_ids="this.purchaseOrderForm.requisition"
                                  @load-item="loadItem"
            ></RequisitionItemModal>
    </div>
</template>
<script>
import Datepicker from 'vuejs-datepicker';
import PurchaseOrderCreate from "../mixin/purchase-order/PurchaseOrderCreate";
import CkEditorHelper from "../mixin/ck-editor";
import RequisitionItemModal from "./RequisitionItemModal";

export default {
    name: "Form",
    props: {
        user_id: {
            type: Number,
            required: false
        },
        revert_mode: {
            type: Boolean,
            required: false
        },
        id: {
            type: Number,
            required: false
        }
    },
    data: () => ({
        errors: '',
        purchaseOrder: {},
        purchaseOrderForm: {
            terms_and_condition:''
        },
        purchaseOrderItem: {},
        addCount: 1,
        items: [],
        itemErrorMessage:'',
        showAlert: false,
        message: '',
        requisitionModal:false,
        currency: 'Tk. ',
        loader:true

    }),
    mixins:[PurchaseOrderCreate,CkEditorHelper],
    components: {
        Datepicker,
        RequisitionItemModal,
    },
    mounted() {
        if (this.revert_mode == true) {
            console.log('revert mode');
            this.editPurchaseOrder(this.id);
        } else {
            console.log('create mode');
        }
        this.getItem();
        this.initialPurchaseOrderForm();
        this.purchaseOrderCreateInfo();
    },

    methods: {
        async purchaseOrderCreateInfo() {
            await axios.get('/purchase-order/create/info')
                .then((response) => {
                    this.purchaseOrder = response.data;
                    this.loader = false;
                    console.log('purchaseOrder', this.purchaseOrder)
                }).catch((error) => {
                    this.loader = false;
                    console.log(error)
                })
        },
        initialPurchaseOrderForm(value = 0) {
            this.purchaseOrderForm = {
                total_price_without_vat: value,
                total_price_with_vat: value,
                revert_mode: false,
            };
            this.purchaseOrderItem = [{
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
            }]
        },
        addItem() {
            let newItem = [];
            for (let i = 0; i < this.addCount; i++) {
                newItem.push(Object.assign({}, this.sampleItem))
            }
            this.purchaseOrderItem = this.purchaseOrderItem.concat(newItem)
        },
        deleteItem(product) {
            if (this.purchaseOrderItem.length == 1) {
                return;
            }
            let index = this.purchaseOrderItem.findIndex(e => e === product);
            this.purchaseOrderItem.splice(index, 1);
        },
         getItem() {
             axios.get('/purchase-order/item')
                .then((response) => {
                    this.items = response.data.data;
                    this.loader = false;
                }).catch((error) => {
                 this.loader = false;
                    console.log(error);
                })
        },
        changeItem(product, index,quantityChange=false) {

            let quantity = this.setQuantity(product.quantity);
            let findProduct = this.items.find((e) => e.id == product.item_id);
            console.log('findProduct',findProduct);
            let unit_price = findProduct.price ? findProduct.price : 0;
            let total_price_without_vat = quantity * unit_price;
            this.purchaseOrderItem[index].category_name = findProduct.category;
            this.purchaseOrderItem[index].category_id = findProduct.category_id;
            if(!quantityChange){
                this.purchaseOrderItem[index].description = findProduct.description;
            }

            this.purchaseOrderItem[index].quantity = quantity;
            this.purchaseOrderItem[index].uom = findProduct.uom;
            this.purchaseOrderItem[index].uom_id = findProduct.uom_id;
            this.purchaseOrderItem[index].unit_price = this.numberFormat(unit_price);
            this.purchaseOrderItem[index].total_price_without_vat = this.numberFormat(total_price_without_vat);
            this.purchaseOrderItem[index].total_price_with_vat = this.numberFormat(total_price_without_vat);
            this.purchaseOrderItem[index].vat = this.numberFormat(this.purchaseOrderItem[index].vat);
            if(this.purchaseOrderItem[index].vat){
                this.vatSelect(product,index);
            }else{
                this.subTotal();
            }
        },

        vatSelect(product,index){
            console.log('vat change', product);
            let vatPercent = Number.parseFloat(product.vat) / 100;
            let total_price_without_vat = product.total_price_without_vat;
            let vat_amount = (Number.parseFloat(total_price_without_vat) * vatPercent);
            let total_price_with_vat = Number(total_price_without_vat) + Number(vat_amount);
            this.purchaseOrderItem[index].vat_amount = this.checkIsNan(vat_amount);
            this.purchaseOrderItem[index].total_price_with_vat = this.checkIsNan(total_price_with_vat);
            this.subTotal();
        },
        changeUnitPrice(product,index){
            let total_price_without_vat = product.quantity * product.unit_price;
            this.purchaseOrderItem[index].total_price_without_vat = total_price_without_vat;
            this.vatSelect(product,index);
        },
        store(){
            let formData = new FormData();
            if(this.purchaseOrderForm.delivery_date){
                this.purchaseOrderForm.delivery_date = new Date(this.purchaseOrderForm.delivery_date).toISOString();
            }
            this.purchaseOrderForm.terms_and_condition = this.editorData;

            for (let key in this.purchaseOrderForm) {
                formData.append(key, this.purchaseOrderForm[key]);
            }
            formData.append('purchaseOrderDetails', JSON.stringify(this.purchaseOrderItem));

            axios.post('/purchase-order/store', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                console.log('response', response);
                this.message = response.data.message;
                this.showAlert = true;
                window.location.href = window.APP_URL + '/purchase-orders';

            }).catch((error) => {
                console.log('error',error.response);
                if (error.response.status == 400) {
                    this.itemErrorMessage = error.response.data.message;
                }
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            })
        },
        loadPRItem(){
            if(this.purchaseOrderForm.requisition){
                this.requisitionModal = !this.requisitionModal;
            }
        },
        loadItem(loadRequisitionItems){
            let newItem = this.purchaseOrderItem.concat(loadRequisitionItems);
            const uniqueIds = [];
            const uniqueItem = newItem.filter(element => {
                const isDuplicate = uniqueIds.includes(element.requisition_detail_id);
                if (!isDuplicate) {
                    uniqueIds.push(element.requisition_detail_id);
                    return true;
                }
                return false;
            }).filter((e) => e.item_id != '');
            this.purchaseOrderItem = uniqueItem;
            this.subTotal();
        },
        changeCostCenter(id){
            this.getCompany(id);
        },
        async editPurchaseOrder(id) {
            await axios.get(`/purchase-order/edit/${id}`)
                .then((response) => {
                    console.log('response', response.data.data);
                     this.purchaseOrderForm = response.data.data;
                    this.purchaseOrderItem = response.data.data.purchase_order_item;
                    this.getCompany(this.purchaseOrderForm.cost_center_id);
                    this.loader = false;
                }).catch((error) => {
                    console.log(error)
                    this.loader = false;
                })

        },
    },
}
</script>

