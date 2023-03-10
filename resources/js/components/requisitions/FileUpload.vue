<template>
    <div>
        <div v-for="(singleInput, index) in requisitionItem">
            <input type="file" class="form-control mb-2" :id="index" v-on:change="onFileChange2">
            <a class="btn btn-icon btn-danger btn-sm glow mr-1 mb-1 text-white cursor-pointer"
               @click="deleteItem(singleInput)">
                <i class="bx bx-trash-alt"></i></a>
            <a  class="btn btn-icon btn-success btn-sm glow mr-1 mb-1 text-white cursor-pointer" @click="addItem">
                <i class="bx bx-plus-circle"></i>
            </a>
        </div>
<!--        <button class="btn btn-sm btn-info" @click="addItem"> Add More</button>-->
    </div>
</template>
<script>

export default {
    name: "FileUpload",
    data() {
        return {
            file: '',
            files:[],
            addCount: 1,
            requisitionItem: [{
                file: "",
            }],
            sampleItem: {
                file: ''
            },
        }
    },
    methods: {
        onFileChange2(e) {
            let file = e.target.files[0];
            let index = e.target.id;
            this.files[index]=file;
            console.log('files',this.files);
            this.$emit('file-handle', this.files);
        },
        addItem() {
            let newItem = [];
            for (let i = 0; i < this.addCount; i++) {
                newItem.push(Object.assign({}, this.sampleItem))
            }
            this.requisitionItem = this.requisitionItem.concat(newItem);
        },
        deleteItem(singleInput) {
            if (this.requisitionItem.length == 1) {
                return;
            }
            let index = this.requisitionItem.findIndex(e => e === singleInput);
            this.requisitionItem.splice(index, 1);
            this.files.splice(index, 1);
        },
    }
}
</script>

