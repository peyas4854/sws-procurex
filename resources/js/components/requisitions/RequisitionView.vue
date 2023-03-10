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
        <div v-else>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <div class="align-self-center flex-fill ">
                                    <h5 class="card-title"> Purchase Requisition(PR) Reference #{{
                                            requisition.requisition_code
                                        }} <span class="badge badge-pill " :class="badgeClass(requisition.status)">{{
                                                requisition.status
                                            }} </span></h5>

                                </div>
                                <div class="align-self-center flex-fill ">
                                    Created At : {{ requisition.created_at }}
                                </div>
                                <div class="heading-elements">
                                    <a :href="`/requisitions/${requisition.id}/edit`" class="btn btn-icon btn-success glow mr-1 mb-1" v-if="requisition.it_team_edit_access">
                                        <i class="bx bx-edit-alt"></i> Edit PR
                                    </a>
                                    <a class="btn btn-light mr-1 mb-1 text-white" href="/requisitions">
                                        <i class="bx bx-left-arrow-alt"></i> Back to list
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-md-12 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body pb-0 mx-25">
                                <div class="row my-2 py-50">
                                    <div class="col-sm-4 col-12 order-2 order-sm-1">
                                        <label for="item_type">Item Type </label>
                                        <input type="text" v-model="requisition.item_type" class="form-control"
                                               placeholder="" readonly>
                                    </div>
                                    <div class="col-sm-4 col-12 order-2 order-sm-1">
                                        <div class="form-group">
                                            <label for="cost_center">Cost Center </label>
                                            <input type="text" v-model="requisition.cost_center" class="form-control"
                                                   placeholder="" readonly>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!-- invoice address and contact -->
                                <div class="row invoice-info">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="employee">Employee </label>
                                            <p class="form-control" readonly v-if="requisition.employee">
                                                {{ requisition.employee.full_name }} </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="designation">Designation</label>
                                            <p class="form-control" readonly v-if="requisition.employee">
                                                {{ requisition.employee.designation.name }} </p>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="department">Department </label>
                                            <p class="form-control" readonly v-if="requisition.employee">
                                                {{ requisition.employee.department.name }} </p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="application_date">Application Date </label><br>
                                            <input type="text" v-model="requisition.application_date"
                                                   class="form-control"
                                                   placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="required_date">Required Date </label><br>
                                            <input type="text" v-model="requisition.required_date" class="form-control"
                                                   placeholder="" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="budget_info">Budget info</label>
                                            <select v-model="requisition.budget_info" class="form-control"
                                                    :disabled="requisition.approval_stage == 'procurement_team' ? false:true">
                                                <option disabled selected>Please select one</option>
                                                <option v-for="(budgetInfo,index) in requisition.budget_list"
                                                        :value="index">
                                                    {{ budgetInfo }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="procurement_type">Procurement Type </label>
                                            <select v-model="requisition.procurement_type" class="form-control"
                                                    :disabled="requisition.approval_stage == 'procurement_team' ? false:true">
                                                <option disabled selected>Please select one</option>
                                                <option v-for="(procurementType,index) in requisition.procurement_list"
                                                        :value="index">{{ procurementType }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="delivery_location" class="d-block">Delivery Location & DB/Hub
                                                name </label>
                                            <textarea readonly rows="2" class="d-block"
                                                      v-model="requisition.delivery_location"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="contact_person_name_and_number">Contact Person Name &
                                                Number </label>
                                            <input type="text" class="form-control"
                                                   v-model="requisition.contact_person_name_and_number" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Description" class="d-block">Description </label>
                                            <textarea readonly rows="2" class="d-block"
                                                      v-model="requisition.description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="card-body pt-50">
                                <!-- product details table-->
                                <div class="invoice-product-details">
                                    <button class="btn btn-primary mb-2" v-if="requisition.export_access"
                                            @click="itemExport">Download as excel
                                    </button>
                                    <form class="form invoice-item-repeater">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th width="3%">Sl.</th>
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
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(product, index) in requisition.reqisition_details">
                                                <td>
                                                    {{ index + 1 }}
                                                </td>
                                                <td scope="row">
                                                    <p readonly="" v-if="product.item"> {{ product.item.name }} </p>
                                                </td>
                                                <td>
                                                    <p readonly="" v-if="product.description">
                                                        {{ product.description }} </p>
                                                </td>
                                                <td>
                                                    <p readonly=""> {{ product.brand }} </p>
                                                </td>
                                                <td>
                                                    <p readonly="" v-if="product.quantity"> {{ product.quantity }} </p>
                                                </td>
                                                <td>
                                                    <p readonly="" v-if="product.uom"> {{ product.uom }} </p>
                                                </td>
                                                <td>
                                                    <p readonly="" v-if="product.unit_price"> {{
                                                            product.unit_price
                                                        }} </p>
                                                </td>
                                                <td>
                                                    <p readonly="" v-if="product.price"> {{ product.price }} </p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <!-- invoice subtotal -->
                                <hr>
                                <div class="invoice-subtotal pt-50">
                                    <div class="row">
                                        <div class="col-md-5 col-12">
                                            <h4>Attachments </h4>
                                            <div v-for="files in requisition.files">
                                                <p>{{ files.file_name }} <a :href="files.original_url" target="_blank">
                                                    view </a></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-7 offset-lg-2 col-12">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                                                    <span class="invoice-subtotal-title">Subtotal</span>
                                                    <h6 class="invoice-subtotal-value mb-0">
                                                        {{ requisition.approximate_cost }}</h6>
                                                </li>
                                                <li class="list-group-item py-0 border-0 mt-25">
                                                    <hr>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between border-0 py-0">
                                                    <span
                                                        class="invoice-subtotal-title"> Total (approximate cost)</span>
                                                    <h6 class="invoice-subtotal-value mb-0">
                                                        {{ requisition.approximate_cost }}</h6>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xl-4 col-md-4 col-12" v-if="requisition.approval">
                                            <ApprovalStatusView :approvals="requisition.approval"
                                                                :forward_access="requisition.forward_access"
                                                                :requisition_id="id"
                                                                @reload="forwardReload"

                                            />
                                        </div>
                                        <div class="col-xl-4 col-md-4 col-12">
                                            <div class="card invoice-action-wrapper shadow-none "
                                                 v-if="requisition.approval_access">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="description" class="d-block"> Comment </label>
                                                        <textarea v-model="description" rows="2"
                                                                  class="w-100"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-4 col-12">
                                            <div class="card invoice-action-wrapper shadow-none"
                                                 v-if="requisition.approval_access">
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

                                            <div class="card invoice-action-wrapper shadow-none"
                                                 v-if="requisition.pr_master_access && requisition.status == 'pending'">
                                                <div class="card-body">
                                                    <h6><b> Master user permission for direct Approved/Revert/Reject
                                                        PR</b></h6>
                                                    <div class="invoice-action-btn mb-1">
                                                        <button class="btn btn-success btn-block invoice-send-btn"
                                                                @click="masterAdminStatusChange('approved')">
                                                            <i class="bx bx-send"></i>
                                                            <span>Approve</span>
                                                        </button>
                                                    </div>
                                                    <div class="invoice-action-btn mb-1 d-flex">
                                                        <div class="preview w-50 mr-50">
                                                            <button class="btn btn-warning btn-block"
                                                                    @click="masterAdminStatusChange('reverted')">
                                                                <span class="text-nowrap">Revert</span>
                                                            </button>
                                                        </div>
                                                        <div class="save w-50">
                                                            <button class="btn btn-danger btn-block"
                                                                    @click="masterAdminStatusChange('rejected')">
                                                                <span class="text-nowrap">Reject</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card invoice-action-wrapper shadow-none"
                                                 v-if='requisition.reinitiate'>
                                                <div class="card-body">
                                                    <div class="invoice-action-btn mb-1">
                                                        <button class="btn btn-success btn-block invoice-send-btn"
                                                                @click="reInitiate('approved')">
                                                            <i class="bx bx-send"></i>
                                                            <span>Re-initiate</span>
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
import ApprovalStatusView from "./ApprovalStatusView";
import helpers from '../mixin/helper';

export default {
    name: "RequisitionView.vue",
    props: ['id'],
    mixins: [helpers],
    data() {
        return {
            requisition: {},
            loader: true,
            showAlert: false,
            message: '',
            description: '',
        }
    },
    components: {
        ApprovalStatusView
    },
    mounted() {
        this.getRequisition();
        let api_url = window.APP_URL;
    },
    methods: {
        getRequisition() {
            axios.get(`/requisition/${this.id}`)
                .then((response) => {
                    this.requisition = response.data.data;
                    this.loader = false;
                }).catch((error) => {
                console.log(error)
            })
        },
        numberFormat(value) {
            return value.toFixed(2);
        },
        statusChange(status) {
            this.loader = true;
            let params = {
                status: status,
                requisition_id: this.id,
                approval_id: this.requisition.approval_id,
                description: this.description,
                budget_info: this.requisition.budget_info,
                procurement_type: this.requisition.procurement_type

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
        itemExport() {
            window.location.href = window.APP_URL + `/requisitions/export/${this.id}`;
        },
        forwardReload(message) {
            this.showAlert = true;
            this.message = message;
            this.getRequisition()

        },
        masterAdminStatusChange(status) {
            this.loader = true;
            let params = {
                status: status,
                requisition_id: this.id,
                approval_id: this.requisition.approval_id,
                description: this.description,
                budget_info: this.requisition.budget_info,
                procurement_type: this.requisition.procurement_type

            };
            axios.post(`/requisition/change/master/user/${this.id}`, params)
                .then((response) => {
                    console.log('response', response)
                    this.showAlert = true;
                    this.message = response.data.message;
                    this.loader = false;
                    window.location.href = window.APP_URL + '/requisitions';
                }).catch((error) => {
                console.log(error)
            })
        },
        reInitiate(status) {
            this.loader = true;
            let params = {
                status: status,
                requisition_id: this.id,
            };
            axios.post(`/requisition/reinitiate/${this.id}`, params)
                .then((response) => {
                    this.showAlert = true;
                    this.message = response.data.message;
                    this.loader = false;
                    window.location.href = window.APP_URL + '/requisitions';
                    console.log(error)
                }).catch((error) => {
                this.loader = false;
                alert(error.response.data.message);

            })
        }
    }
}
</script>
