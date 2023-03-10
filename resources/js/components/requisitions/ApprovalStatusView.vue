<template>
    <div>
        <div>
            <div class="d-flex mb-2">
                <h4 class="mr-auto"> Approval Status </h4>
                <button class="btn btn-sm btn-primary" @click="forward()" v-if="forward_access"> Forward</button>
            </div>

            <div class="mb-1 border" v-for="approval in approvals">

                <div class="d-flex border-bottom p-1">
                    <div class="mr-auto">{{ approval.employee }}</div>
                    <span class="badge badge-pill" :class="badgeClass(approval.status)">{{ approval.status }} </span>
                </div>
                <div class="d-flex  p-1" :class="approval.description ? 'border-bottom' : ''">
                    <div class="mr-auto"> Arrival Date: {{ approval.created_at }}</div>
                    <div v-if="approval.status_date"> Release Date : {{ approval.status_date }}</div>
                </div>
                <div class="d-flex p-1" v-if="approval.description">
                    {{ approval.description }}
                </div>
            </div>
        </div>
        <forwardModal v-if="requisitionForwardModal"
                      @closedModal="requisitionForwardModal=false"
                      @forward-employees="forwardEmployees"

        ></forwardModal>
    </div>
</template>

<script>
import helpers from '../mixin/helper';
import forwardModal from "./ForwardModal";
export default {
    props:{
        approvals:{
            type:Array,
            required:true,
        },
        requisition_id: {
            type: Number,
            required: false
        },
        forward_access: {
            type: Boolean,
            required: false
        },

    },
    name: "ApprovalStatusView",
    data() {
        return {
            requisitionForwardModal: false,
        }
    },
    mixins: [helpers],
    components: {
        forwardModal,
    },
    methods: {
        forward() {
            this.requisitionForwardModal = !this.requisitionForwardModal;

        },
        forwardEmployees(employees){
            let params = {
                employees: employees
            };
            axios.post(`/requisition/forward/${this.requisition_id}`, params)
                .then((response) => {
                    this.$emit('reload',response.data.message);
                }).catch((error) => {
                console.log(error);
            })
        }
    }
}
</script>


