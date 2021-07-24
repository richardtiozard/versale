<template>
    <div class="componentwarpper">
        <div class="warpper">
            <div class="px-5 d-flex justify-content-between">
                <h4 class="d-inline-block font-weight-600">
                    <i class="fas fa-comment-dots mr-3"></i> Feedbacks
                </h4>
            </div>

            <div class="px-5 mt-5">
                <form class="row">
                    <div class="col-8 p-0">
                        <h6 class="col-4 d-inline-block text-right">
                            Search by Title:
                        </h6><input v-model="filter.title" type="text" name="name" id='name' class="form-input col-5 d-inline-block" placeholder='Input'>

                        <h6 class="col-4 d-inline-block mt-4 text-right">
                            Status:
                        </h6><select v-model="filter.status" name="status" id='status' class="form-input col-5 d-inline-block">
                            <option value="All"> All </option>
                            <option value="Pending"> Pending </option>
                            <option value="Closed"> Closed </option>
                        </select>
                    </div>
                </form>
                
                <div class="mt-5">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">No.</th>
                                <th scope="col" width="20%">Title</th>
                                <th scope="col" width="30%">Message</th>
                                <th scope="col" width="15%">Email</th>
                                <th scope="col" class="text-center" width="10%">Role</th>
                                <th scope="col" class="text-center" width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in feedbacks" :key="item.feedback_id">
                                <th class="py-4" scope="row">{{index + 1}}.</th>
                                <td class="py-4">{{ item.feedback_title }}</td>
                                <td class="py-4">{{ item.feedback_message }}</td>
                                <a :href="'mailto:'+item.user_email"><td class="py-4 text-6 cursor-pointer">{{item.user_email}} </td></a>
                                <td class="py-4 text-center">{{item.user_role}} </td>
                                <td v-if="item.feedback_status == 'Closed'" class="text-center text-3 py-4"><i class="fas fa-check"></i> {{item.feedback_status}} </td>
                                <td @click="openConfirmModal(item)" v-if="item.feedback_status == 'Pending'" class="text-center text-3 py-4 cursor-pointer"><i class="fas fa-edit"></i> {{item.feedback_status}} </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="feedbacks==''" class="text-7 w-100 text-center">
                        <img :src="'../img/illustrator/emptyview.png'" class="pointer-events-none empty-img" alt="">
                        <p>No feedbacks to be shown.</p>
                    </div>
                </div>
                

            </div>
        </div>

        <confirm-modal v-if="toggleConfirmModal" @confirmed="completeFeedback" @closeConfirmModal="closeConfirmModal" :title="confirmModalTitle"></confirm-modal>
    </div>
    
</template>

<script>

import ConfirmModal from '../template/ConfirmModal.vue';

export default {
    components:{
        ConfirmModal
    },
    props: [
        'data'
    ],
    data(){
        return{
            feedbacks: this.data.feedbacks,

            filter:{
                title: '',
                status: 'All',
            },

            selected_feedback: '',
            toggleConfirmModal: false,
            confirmModalTitle: '',
        }
    },
    methods:{

        /* COMPLETE FEEDBACK */
        openConfirmModal(feedback){
            this.selected_feedback = feedback;
            this.confirmModalTitle = "Are you sure you want to close the feedback?";
            this.toggleConfirmModal = true;
            document.body.style.overflow = 'hidden';
        },
        closeConfirmModal(){
            this.toggleConfirmModal = false;
            document.body.style.overflow = 'auto';
        },
        completeFeedback(){
            axios.put('/feedbacks',{ 
                'feedback_id': this.selected_feedback.feedback_id, 
            })
            .then( response => {
                console.log(response.data);
                this.closeConfirmModal();
                window.location.href = "/feedbacks";
            })
            .catch ( error => {
                console.log(error.response.data);
            })
        },

        /* FILTER FEEDBACKS */
        filterData(){
            var filtereddata = [];
            if( this.filter.status == 'All'){
                for( var item in this.data.feedbacks){
                    if (this.data.feedbacks[item].feedback_title.toLowerCase().includes(this.filter.title.toLowerCase())){
                        filtereddata.push(this.data.feedbacks[item]);
                    }
                }
                this.feedbacks = filtereddata;
            }
            else if( this.filter.status != 'All'){
                for( var item in this.data.feedbacks){
                    if (this.data.feedbacks[item].feedback_title.toLowerCase().includes(this.filter.title.toLowerCase()) && this.data.feedbacks[item].feedback_status.toLowerCase().includes(this.filter.status.toLowerCase())){
                        filtereddata.push(this.data.feedbacks[item]);
                    }
                }
                this.feedbacks = filtereddata;
            }
        },
    },
    watch:{
        'filter.title': function(newVal, oldVal){
            this.filterData();
        },
        'filter.status': function(newVal, oldVal){
            this.filterData();
        },
    },
    mounted(){
        console.log(this.data)
    }
}
</script>

<style>
    .form-input{
        background-color: transparent;
        color: #333333;
        border: 2px solid #999999;
        padding: 5px;
        border-radius: 0;
        width: 100%;
    }
    .form-input:focus{
        background-color: transparent;
        color: #333333;
        border: 2px solid #333333;
        padding: 5px;
        border-radius: 0;
        width: 100%;
    }
    .form-input::placeholder{
        color: #999999;
    }

    .empty-img{
        opacity: 0.8;
    }
    .product-img{
        width: 100px;
        height: 100px;
        object-fit: contain;
    }
    .buyer-img{
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
    }
</style>