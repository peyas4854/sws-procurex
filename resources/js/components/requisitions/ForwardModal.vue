<template>
    <div>
        <div class="modal fade" tabindex="-1" role="dialog" id="requisition-forward-modal">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">PR Forward</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <Loader v-if="loader"/>
                    <div class="modal-body" v-if="!loader">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cost_center">Employee</label>
                                    <v-select :options="employeeList"
                                              v-model="employees"
                                              :reduce="(option) => option.id"
                                              multiple
                                              label="code_name"
                                    ></v-select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="forward">Forward PR</button>
                        <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ForwardModal",
    props: {
        requisition_ids: {
            type: Array,
            required: false
        }
    },
    data: () => ({
        employeeList: [],
        employees:'',
        loader:true,

    }),
    mounted() {
        this.openModal();
    },
    methods: {
        openModal() {
            $('#requisition-forward-modal').modal('show');
            this.getEmployee();
        },
        closeModal() {
            $('#requisition-forward-modal').modal('hide');
            this.$emit('closedModal', 'yes')
        },
        getEmployee() {
            axios.get('/get-employee')
                .then((response) => {
                    this.employeeList = response.data;
                    this.loader=false;
                }).catch((error) => {
                console.log(error);
                this.loader=false
            })
        },
        forward(){
            this.$emit('forward-employees',this.employees);
            this.closeModal();
        }
    }
}
</script>
