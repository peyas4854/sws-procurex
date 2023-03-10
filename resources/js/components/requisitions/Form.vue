<template>
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
                            <!-- logo and title -->
                            <div class="row my-2 py-50">
                                <div class="col-sm-3 col-12 order-2 order-sm-1">
                                    <label for="item_type">Item Type </label>
                                    <select v-model="requisitionForm.item_type" class="form-control">
                                        <option disabled selected>Please select item type</option>
                                        <option v-for="(itemType,index) in requisition.itemType" :value="index">
                                            {{ itemType }}
                                        </option>
                                    </select>
                                    <span v-if="errors.item_type" class="text-danger"> {{ errors.item_type[0] }}</span>
                                    <span v-if="itemTypeError" class="text-danger"> {{ itemTypeError }}</span>
                                </div>
                            </div>
                            <hr>
                            <!-- invoice address and contact -->
                            <div class="row invoice-info">
                                <div class="col-md-3">
                                    <div class="form-group">

                                        <label for="employee">Employee </label>
                                        <v-select :options="requisition.employeeList"
                                                  v-model="requisitionForm.employee_id"
                                                  :reduce="(option) => option.id"
                                                  @input="selectEmployee"
                                                  label="code_name"></v-select>
                                        <span v-if="errors.employee_id" class="text-danger"> {{
                                                errors.employee_id[0]
                                            }}</span>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="designation">Designation</label>
                                        <v-select :options="requisition.designationList"
                                                  v-model="requisitionForm.designation_id"
                                                  :reduce="(option) => option.id"
                                                  :disabled="true"
                                                  label="name"
                                        ></v-select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="department">Department </label>
                                        <v-select :options="requisition.departmentList"
                                                  v-model="requisitionForm.department_id"
                                                  :reduce="(option) => option.id"
                                                  :disabled="true"
                                                  label="name"
                                        ></v-select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cost_center">Cost Center</label>
                                        <select v-model="requisitionForm.cost_center_id" class="form-control select2"
                                                :disabled="!costCenterChangeable">
                                            <option disabled selected>Please select cost center</option>
                                            <option v-for="(costCenter,index) in requisition.costCenterList"
                                                    :value="costCenter.id">
                                                {{ costCenter.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="application_date">Requisition Date </label>
                                        <input type="text" readonly class="form-control"
                                               v-model="requisitionForm.application_date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="requisition_date">Required Date </label> <br>
                                        <Datepicker v-model="requisitionForm.required_date" id="datepicker"
                                                    :disabledDates="disabledDates"
                                                    input-class="date-picker-class"
                                        ></Datepicker>


                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="budhet_info">Budget info</label>
                                        <select v-model="requisitionForm.budget_info" class="form-control">
                                            <option disabled selected>Please select one</option>
                                            <option v-for="(budgetInfo,index) in requisition.budgetInfo" :value="index">
                                                {{ budgetInfo }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="procurement_type">Procurement Type</label>
                                        <select v-model="requisitionForm.procurement_type" class="form-control">
                                            <option disabled selected>Please select one</option>
                                            <option v-for="(procurementType,index) in requisition.procurementType"
                                                    :value="index">{{ procurementType }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="delivery_location" class="d-block">Delivery Location & DB/Hub name
                                            <span class="text-danger">*</span> </label>
                                        <textarea rows="2" class="d-block"
                                                  v-model="requisitionForm.delivery_location"></textarea>

                                        <span v-if="errors.delivery_location"
                                              class="text-danger"> {{ errors.delivery_location[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="contact_person_name_and_number">Contact Person Name & Number <span
                                            class="text-danger">*</span></label>
                                        <input type="text" class="form-control"
                                               v-model="requisitionForm.contact_person_name_and_number">
                                        <span v-if="errors.contact_person_name_and_number"
                                              class="text-danger"> {{ errors.contact_person_name_and_number[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea rows="2" class="d-block"
                                                  v-model="requisitionForm.description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="card-body pt-50">
                            <!-- product details table-->
                            <div class="invoice-product-details ">
                                <form class="form invoice-item-repeater">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th width="25%">Item</th>
                                            <th width="20%" data-toggle="tooltip" data-placement="top"
                                                title="Description/Specification">Desc/Spec
                                            </th>
                                            <th width="10%">Brand/Model</th>
                                            <th width="8%">Quantity</th>
                                            <th width="8%">UoM</th>
                                            <th width="8%" data-toggle="tooltip" data-placement="top"
                                                title="Latest Unit Price">LUP
                                            </th>
                                            <th width="8%">Total Price</th>
                                            <th width="5%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(product, index) in requisitionItem">
                                            <td scope="row">
                                                <v-select :options="items"
                                                          :reduce="(option) => option.id"
                                                          v-model="product.item_id"
                                                          label="name"
                                                          @input="changeItem(product,index)"
                                                ></v-select>
                                            </td>
                                            <td>
                                                <textarea v-model="product.description" class="from-control w-100"
                                                          rows="2" data-toggle="tooltip" data-placement="top"
                                                          :title="product.description"></textarea>
                                            </td>
                                            <td>
                                                <input type="text" v-model="product.brand" class="form-control"
                                                       data-toggle="tooltip" data-placement="top"
                                                       :title="product.brand"
                                                >
                                            </td>
                                            <td>
                                                <input type="number" v-model="product.quantity" class="form-control"
                                                       @keyup="changeItem(product,index,true)"
                                                       data-toggle="tooltip" data-placement="top"
                                                       :title="product.quantity"
                                                >
                                            </td>
                                            <td>
                                                <input type="text" v-model="product.uom_name" class="form-control"
                                                       readonly
                                                       data-toggle="tooltip" data-placement="top"
                                                       :title="product.uom_name"
                                                >
                                            </td>
                                            <td>
                                                <input type="number" v-model="product.unit_price" class="form-control"
                                                       data-toggle="tooltip" data-placement="top"
                                                       :title="product.unit_price"
                                                       :disabled="!requisitionForm.item_price_edit_access"
                                                       @keyup="changeItem(product,index,true,true)"
                                                >
                                            </td>
                                            <td>
                                                <input type="number" v-model="product.total_price" class="form-control"
                                                       readonly
                                                       data-toggle="tooltip" data-placement="top"
                                                       :title="product.total_price">
                                            </td>
                                            <td>
                                                <a class="btn btn-icon btn-danger btn-sm glow mr-1 mb-1 text-white cursor-pointer"
                                                   @click="deleteItem(product)" :disabled="requisitionItem.length ==1 ">
                                                    <i class="bx bx-trash-alt"></i></a>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                    <span v-if="itemErrorMessage" class="text-danger"> {{ itemErrorMessage }}</span>

                                    <div class="form-group" v-if="create_mode || requisitionForm.revert_access || requisitionForm.it_team_edit_access">
                                        <div class="col p-0" >
                                            <button class="btn btn-light-primary btn-sm" data-repeater-create
                                                    type="button"
                                                    @click="addItem">
                                                <i class="bx bx-plus"></i>
                                                <span class="invoice-repeat-btn">Add Item</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- invoice subtotal -->
                            <hr>
                            <div class="invoice-subtotal pt-50">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="card invoice-action-wrapper shadow-none border"
                                             v-if="create_mode || requisitionForm.revert_access || requisitionForm.it_team_edit_access">
                                            <div class="card-body">
                                                <h4>Attachments</h4>
                                                <file-upload @file-handle="filehandle"/>
                                                <h5> Previous Files</h5>
                                                <div v-for="files in requisitionForm.files">
                                                    <p><a
                                                        class="btn btn-icon btn-danger btn-sm glow mr-1 mb-1 text-white cursor-pointer"
                                                        @click="deleteFiles(files)">
                                                        <i class="bx bx-trash-alt"></i>
                                                    </a> {{ files.file_name }}  <a :href="files.original_url" target="_blank">
                                                        view </a></p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12"  v-if="(requisitionForm.it_team_edit_access && requisitionForm.approval_access)">
                                        <div class="card invoice-action-wrapper shadow-none">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="description" class="d-block"> Comment </label>
                                                    <textarea v-model="comment" rows="2"
                                                              class="w-100"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12" :class="(requisitionForm.it_team_edit_access && requisitionForm.approval_access)? '':'offset-4'">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                                                <span class="invoice-subtotal-title">Subtotal</span>
                                                <h6 class="invoice-subtotal-value mb-0"> {{ currency }} {{
                                                        requisitionForm.sub_total
                                                    }}</h6>
                                            </li>

                                            <li class="list-group-item py-0 border-0 mt-25">
                                                <hr>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between border-0 py-0">
                                                <span class="invoice-subtotal-title"> Total (approximate cost)</span>
                                                <h6 class="invoice-subtotal-value mb-0"> {{ currency }} {{
                                                        requisitionForm.sub_total
                                                    }}</h6>
                                            </li>
                                        </ul>
                                        <hr>
                                        <div class="invoice-action-btn mb-1">
                                            <button class="btn btn-success btn-block invoice-send-btn"
                                                    v-if="(requisitionForm.it_team_edit_access && requisitionForm.approval_access)"
                                                    @click="saveAndSendRequisition"
                                            >
                                                <i class="bx bx-send"></i>
                                                <span>Save & Approve Requisition(PR)</span>
                                            </button>
                                            <button class="btn btn-primary btn-block invoice-send-btn"
                                                    v-if="create_mode"
                                                    @click="saveRequisition">
                                                <i class="bx bx-send"></i>
                                                <span>Send Purchase Requisition(PR)</span>
                                            </button>

                                            <button class="btn btn-primary btn-block invoice-send-btn"
                                                    v-if="requisitionForm.revert_access"
                                                    @click="reSendRequisition">
                                                <i class="bx bx-send"></i>
                                                <span>Resend Purchase Requisition(PR)</span>
                                            </button>


                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7 col-12" v-if="requisitionForm.approval">
                                        <ApprovalStatusView :approvals="requisitionForm.approval"

                                                            :forward_access="requisitionForm.forward_access"
                                                            :requisition_id="requisitionForm.id"


                                        />
                                    </div>
                                    <div class="col-md-5 col-12">
                                        <div class="card invoice-action-wrapper shadow-none border mt-md-4"
                                             v-if="requisitionForm.approval_access">
                                            <div class="card-body">
                                                <div class="invoice-action-btn mb-1">
                                                    <button class="btn btn-success btn-block invoice-send-btn"
                                                            @click="statusChange('approved')">
                                                        <i class="bx bx-send"></i>
                                                        <span>Approve</span>
                                                    </button>
                                                </div>
                                                <div class="invoice-action-btn mb-1 d-flex">
                                                    <div class="preview w-50 mr-50">
                                                        <button class="btn btn-warning btn-block"
                                                                @click="statusChange('reverted')">
                                                            <span class="text-nowrap">Revert</span>
                                                        </button>
                                                    </div>
                                                    <div class="save w-50">
                                                        <button class="btn btn-danger btn-block"
                                                                @click="statusChange('rejected')">
                                                            <span class="text-nowrap">Reject</span>
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
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
import Datepicker from 'vuejs-datepicker';
import ApprovalStatusView from "./ApprovalStatusView";

export default {
    name: "Form.vue",
    props: {
        user_id: {
            type: Number,
            required: true
        },
        revert_mode: {
            type: Boolean,
            required: false
        },
        id: {
            type: Number,
            required: false
        },
        create_mode: {
            type: Boolean,
            required: false
        },
    },
    components: {
        Datepicker,
        ApprovalStatusView
    },
    data() {
        return {
            requisition: {},
            requisitionForm: {},
            files: [],
            addCount: 1,
            requisitionItem: [],
            sampleItem: {
                id: null,
                item_id: null,
                quantity: null,
                unit_price: null,
                total_price: null,
                uom_id: null,
                description: null,
                brand_id: null,
            },
            items: [],
            showAlert: false,
            message: '',
            errors: '',
            currency: 'Tk. ',
            loader: true,
            showTimePanel: true,
            disabled: true,
            disabledDates: {
                to: moment().add(2, 'd').toDate()
            },
            value: new Date(),
            dateFormat: '',
            itemErrorMessage: '',
            itemTypeError: '',
            comment:'',
        }
    },
    computed: {
        costCenterChangeable() {
            if (this.requisition.changeCostCenterDepartments) {
                return this.requisition.changeCostCenterDepartments.includes(this.requisitionForm.department_id);
            }
        }
    },

    mounted() {
        let api_url = window.APP_URL;
        this.requisitionCreateInfo();
        if (this.revert_mode == true) {
            console.log('revert mode', true);
            this.editRequisition(this.id)
        } else {
            this.initialRequisitionForm(0, 'it')
            this.getItem(this.requisitionForm.item_type);
        }
    },

    watch: {
        'requisitionForm.item_type'(newVal, oldVal) {
            if (oldVal) {
                if (confirm("After change item type form will be empty . Are you sure want to change?")) {
                    this.getItem(newVal);
                    this.requisitionItem = [{
                        item_id: '',
                        quantity: 0,
                        unit_price: 0,
                        total_price: 0,
                    }];
                }else{
                    this.initialRequisitionForm(0, 'it')
                    this.getItem(this.requisitionForm.item_type);
                }
            }
        }
    },
    methods: {
        async requisitionCreateInfo() {
            await axios.get('/requisition/create/info')
                .then((response) => {
                    this.requisition = response.data;
                    this.setCurrentDate(this.requisition.dateFormate);
                    this.dateFormat = this.requisition.dateFormate.toUpperCase();
                    if (this.user_id) {
                        this.selectEmployee(this.user_id);
                    }
                    this.loader = false;
                }).catch((error) => {
                    this.loader = false;
                    console.log(error)
                })

        },
        async getItem(value) {
            this.loader = true;
            await axios.get(`/get/item/${value}`)
                .then((response) => {
                    this.items = response.data.data;
                    this.loader = false;
                }).catch((error) => {
                    console.log(error);
                    this.loader = false;
                })
        },
        setCurrentDate(format) {
            let dateFormat = format.toUpperCase()
            this.requisitionForm.application_date = moment(new Date()).format(dateFormat);

        },
        selectEmployee(user_id) {
            let findEmployee;
            if (user_id) {
                findEmployee = this.requisition.employeeList.find((e) => e.id == user_id);
            } else {
                findEmployee = this.requisition.employeeList.find((e) => e.id == this.requisitionForm.employee_id);
            }
            if(!this.requisitionForm.revert_mode){
                this.requisitionForm.cost_center_id = findEmployee.cost_center_id;
            }
            this.requisitionForm.department_id = findEmployee.department_id;
            this.requisitionForm.designation_id = findEmployee.designation_id;
            this.requisitionForm.employee_id = findEmployee.id;
        },
        addItem() {
            let newItem = [];
            for (let i = 0; i < this.addCount; i++) {
                newItem.push(Object.assign({}, this.sampleItem))
            }
            this.requisitionItem = this.requisitionItem.concat(newItem)
        },
        deleteItem(product) {
            if (this.requisitionItem.length == 1) {
                return;
            }
            let index = this.requisitionItem.findIndex(e => e === product);
            this.requisitionItem.splice(index, 1);
            this.requisitionForm.sub_total = this.subTotal();
        },
        saveRequisition() {
            this.loader = true;
            let formData = new FormData();
            if (this.requisitionForm.required_date) {
                this.requisitionForm.required_date = new Date(this.requisitionForm.required_date).toISOString();
            }
            for (let key in this.requisitionForm) {
                formData.append(key, this.requisitionForm[key]);
            }
            formData.append('itemData', JSON.stringify(this.requisitionItem));
            this.files.forEach((files, index) => {
                formData.append(`files[${index}]`, files);
            })
            axios.post('/requisition/store', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {

                this.message = response.data.message;
                this.showAlert = true;
                this.loader = false;
                window.location.href = window.APP_URL + '/requisitions';

            }).catch((error) => {
                this.loader = false;
                if (error.response.status == 400) {
                    this.itemErrorMessage = error.response.data.message;
                    this.itemTypeError = error.response.data.item_type_error;
                    console.log('itemTypeError',this.itemTypeError);
                }
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            })
        },
        changeItem(product, index, quantityChange = false,priceChange=false) {
            if (product.item_id == null) {
                this.deleteItem(product);
                return;
            }
            let quantity = this.setQuantity(product.quantity);
            let findProduct = this.items.find((e) => e.id == product.item_id);
            let findUom = this.requisition.uomList.find((e) => e.id == findProduct.uom_id);
            let price = findProduct.price ? findProduct.price : 0;
            if(priceChange){
                price = product.unit_price;
                console.log('df',product)
            }else{
                price = findProduct.price ? findProduct.price : 0;
                this.requisitionItem[index].unit_price = this.numberFormat(price);
            }
            this.requisitionItem[index].quantity = quantity;
            this.requisitionItem[index].uom_id = findProduct.uom_id;
            this.requisitionItem[index].uom_name = findUom.name;
            if (quantityChange == false) {
                this.requisitionItem[index].description = findProduct.description;
            }

            let total_price = quantity * price;
            this.requisitionItem[index].total_price = this.numberFormat(total_price);
            this.requisitionItem[index].price = total_price;
            this.requisitionForm.sub_total = this.subTotal();
        },
        changeUnitPrice(product,index){
            console.log('product',product)
            console.log('index',index)
        },
        setQuantity(quantity) {
            if (quantity) {
                return quantity == 0 ? 1 : quantity;
            } else {
                return 1;
            }
        },
        subTotal() {
            let total = this.requisitionItem.map(e => e.price).reduce((prev, next) => prev + next);
            return isNaN(total) == true ? 0 : this.numberFormat(total);

        },
        reset() {
            this.requisitionForm = {
                sub_total: 0,
                invoice_total: 0,
                comment:''
            };
            this.requisitionItem = [{
                id: null,
                item_id: '',
                quantity: 1,
                unit_price: 0,
                total_price: 0,
            }];
        },
        numberFormat(value) {
            return Number.parseFloat(value).toFixed(2);
        },
        filehandle(files) {
            this.files = files;
        },
        async editRequisition(id) {
            await axios.get(`/requisition/edit/${id}`)
                .then((response) => {
                    this.requisitionForm = response.data.data;
                    console.log('requisitionForm',this.requisitionForm);
                    this.requisitionItem = response.data.data.requisition_details;
                    this.getItem(this.requisitionForm.item_type);
                    this.loader = false;
                }).catch((error) => {
                    console.log(error)
                })

        },
        initialRequisitionForm(value = "", item_type = "") {
            this.requisitionForm = {
                sub_total: value,
                invoice_total: value,
                item_type: item_type,
                revert_mode: false,
            };
            this.requisitionItem = [{
                id: null,
                quantity: null,
                uom_id: null,
                unit_price: null,
                total_price: null,
                description: null,
                brand_id: null,
            }]
        },
        saveAndSendRequisition() {
            this.loader = true;
            let formData = new FormData();
            if (this.requisitionForm.required_date) {
                this.requisitionForm.required_date = new Date(this.requisitionForm.required_date).toISOString();
            }
            if(this.comment){
                this.requisitionForm.description= this.comment;
            }
            for (let key in this.requisitionForm) {
                formData.append(key, this.requisitionForm[key]);
            }
            formData.append('itemData', JSON.stringify(this.requisitionItem));
            this.files.forEach((files, index) => {
                formData.append(`files[${index}]`, files);
            })
            axios.post('/it-team/requisition/store', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                this.statusChange('approved');
            }).catch((error) => {
                this.loader = false;
                if (error.response.status == 400) {
                    this.itemErrorMessage = error.response.data.message;
                }
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            })
        },
        statusChange(status) {
            this.loader = true;
            let params = {
                status: status,
                requisition_id: this.requisitionForm.id,
                approval_id: this.requisitionForm.approval_id,
                description: this.comment,
            };
            axios.post(`/bu-head/change/${this.id}`, params)
                .then((response) => {
                    this.showAlert = true;
                    this.message = response.data.message;
                    this.loader = false;
                    window.location.href = window.APP_URL + '/requisitions';
                }).catch((error) => {
                console.log(error)
            })
        },
        reSendRequisition() {
            this.saveRequisition();
        },
        deleteFiles(file) {
                if (confirm("Are you sure want to delete files?")) {
                    this.loader = true;
                    let params = {
                        uuid: file.uuid,
                        model_type:`App\\Models\\Requisition`
                    };
                    axios.post(`/file/delete`, params)
                        .then((response) => {
                            console.log('response',response)
                            this.showAlert = true;
                            this.message = response.data.message;
                            this.editRequisition(this.id)
                            this.loader = false;
                        }).catch((error) => {
                        console.log(error)
                    })
                }
            }
        }
}
</script>

