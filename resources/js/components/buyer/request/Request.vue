<template>
    <div class="componentwarpper">
        <div class="warpper min-vh-100">
            <div class="content-warpper d-flex justify-content-between">
                <h4 class="d-inline-block font-weight-600">My Requests</h4>

                <a :href="'/requests/create'">
                    <div class="d-inline-block text-3">
                        New Request <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>

            <div class="content-warpper mt-3">
                <div @click="getAllRequests" class="filter-button d-inline-block text-center mr-2 py-1 text-7 cursor-pointer" :class="{active: filter == 'All'}">
                    All
                </div>
                <div @click="getPendingRequests" class="filter-button d-inline-block text-center mr-2 py-1 text-7 cursor-pointer" :class="{active: filter == 'Pending'}">
                    Pending Requests
                </div>
                <div @click="getOfferedRequests" class="filter-button d-inline-block text-center mr-2 py-1 text-7 cursor-pointer" :class="{active: filter == 'Offered'}">
                    Offered Requests
                </div>
            </div>

            <div v-if="requests==''" class="text-7 w-100 text-center mt-5">
                <img :src="'../img/illustrator/emptyview.png'" class="pointer-events-none empty-img" alt="">
                <p>No request to be shown. Please make a new request.</p>
            </div>

            <div class="content-warpper request-list mt-5">
                <div v-for="request in requests" :key="request.id" class="request-box p-4 text-center position-relative">
                    <p class="text-7 timestamp">{{request.created_at | moment("from") }}</p>
                    <div v-if="request.offerNum > 0" class="band text-1 bg-4 py-1 px-5 shadow-sm">Offered</div>
                    <div v-if="request.offerNum == 0" class="band text-1 bg-2 py-1 px-5 shadow-sm">Pending</div>
                    <img class="categoryimg" :src="request.image" alt="">
                    <h4 class="mt-3">{{ request.title }}</h4>
                    <p class="text-7">{{ request.description }}</p>
                    <p @click="openConfirmDeleteModal(request)" class="text-8 cursor-pointer">Close Request</p>
                    <hr>
                    <div v-if="request.offerNum > 0 && getSellerImage(request.id).length > 0 && getSellerImage(request.id).length <= 5">
                        <img v-for="path in getSellerImage(request.id)" :src="path" alt="" class="sellerimg">
                    </div>
                    <div v-if="request.offerNum > 0 && getSellerImage(request.id).length > 5">
                        <img v-for="path in 4" :src="getSellerImage(request.id)[path-1]" alt="" class="sellerimg">
                        <span class="sellerimgmore d-inline-flex align-items-center justify-content-center">+ More</span>
                    </div>
                    <p class="text-3 mt-3">Offers Received: {{ request.offerNum }}</p>
                    <p v-if="request.offerNum==0" class="text-7">Your request has been sent. Waiting for offers. </p>
                    <div @click="showOffers(request)" class="view-offer-button mx-auto">View Offers</div>
                </div>

            </div>

        </div>

        <Footers/>
        <confirm-modal v-if="toggleConfirmModal" @confirmed="deleteRequest" @closeConfirmModal="closeConfirmModal" :title="confirmModalTitle"></confirm-modal>
    </div>
    
</template>

<script>
import Footers from '../../template/Footers.vue'
import ConfirmModal from '../../template/ConfirmModal.vue';

export default {
    props: ['data'],
    components:{
        Footers,
        ConfirmModal
    },
    data(){
        return{
            sellerimg_num: 0,

            requests: this.data.requests,
            filter: 'All',

            toggleConfirmModal: false,
            confirmModalTitle: '',
            selected_request_id: '',
        }
    },
    methods:{

        /* SHOW OFFERS */
        showOffers(request){
            window.location.href = '/requests/offers/'+request.id;
        },

        /* DELETE REQUEST */
        openConfirmDeleteModal(request){
            this.selected_request_id = request.id;
            this.confirmModalTitle = "Are you sure you want to close request on " + request.title + "?";
            this.toggleConfirmModal = true;
            document.body.style.overflow = 'hidden';
        },
        closeConfirmModal(){
            this.toggleConfirmModal = false;
            document.body.style.overflow = 'auto';
        },
        deleteRequest(){
            axios.delete('/requests',{ 
                data: { 
                    request_id: this.selected_request_id
                } 
            })
            .then( response => {
                console.log(response.data);
                window.location.href = "/requests";
            })
            .catch ( error => {
                console.log(error.response.data);
            })
        },

        getSellerImage(requestid){
            var arr = [];
            for (var item in this.data.seller_images){
                if (this.data.seller_images[item].id == requestid){
                    if ( !arr.includes(this.data.seller_images[item].image) ){
                        arr.push(this.data.seller_images[item].image);
                    }
                }
            }
            return arr;
        },
        
        /* FILTER REQUESTS */
        getAllRequests(){
            this.filter = 'All';
            this.requests = this.data.requests
        },
        getPendingRequests(){
            var arr = [];
            for (var item in this.data.requests){
                if(this.data.requests[item].offerNum == 0){
                    arr.push(this.data.requests[item]);
                }
            }
            this.filter = 'Pending';
            this.requests = arr;
        },
        getOfferedRequests(){
            var arr = [];
            for (var item in this.data.requests){
                if(this.data.requests[item].offerNum > 0){
                    arr.push(this.data.requests[item]);
                }
            }
            this.filter = 'Offered';
            this.requests = arr;
        },
        
    },
    mounted(){
        console.log(this.data);
    }
}

</script>

<style scoped>
    .content-warpper{
        width: 75%;
        margin: 0 auto;
    }

    .filter-button{
        width: 150px;
        transition: all 0.2s ease-in-out 0s;
    } 
    .filter-button:hover{
        color: #134153;
    } 
    .filter-button.active{
        border-bottom: 4px solid #134153;
        font-weight: 600;
        color: #134153;
    } 

    .request-list{
        display: grid;
        grid-template-columns: 30% 30% 30%;
        grid-gap: 50px 5%;
    }
    .categoryimg{
        width: 50px;
    }
    .sellerimg{
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 2px solid #fff;
        object-fit: cover;
        background-color: #BEDAFA;
        margin: 0 -10px;
    }
    .sellerimgmore{
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 2px solid #fff;
        background-color: #134153;
        color: #FCFAF1;
        margin: 0px -10px;
        font-size: 12px;
    }

    .empty-img{
        opacity: 0.8;
    }

    .request-box{
        background-color: #fff;
        text-align: center;
        box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
        transition: all 0.2s ease-in-out 0s;
        overflow: hidden;
    }
    .request-box:hover{
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }
    .band{
        position: absolute;
        top: 20px;
        left: -35px;
        transform: rotate(-45deg);
    }
    .timestamp{
        position: absolute;
        top: 15px;
        right: 15px;
    }

    .request-box h4{
        font-weight: 600;
    }

    .view-offer-button {
        cursor: pointer;
        text-align: center;
        line-height: 45px;
        max-width: 160px;
        margin-top: 25px;
        width: 100%; 
        color: #FCFAF1;
        background-color: rgba(19, 65, 83, 1);

        box-shadow: inset 0 0 20px rgba(190, 218, 250, 0);
        outline-color: rgba(19, 65, 83, .5);
        outline-offset: 0px;
        text-shadow: none;
        transition: all 1250ms cubic-bezier(0.19, 1, 0.22, 1);
    }
    .view-offer-button:hover {
        box-shadow: inset 0 0 20px rgba(190, 218, 250, .5), 0 0 20px rgba(190, 218, 250, .2);
        outline: 1px solid;
        outline-color: rgba(190, 218, 250, 0);
        outline-offset: 15px;
        text-shadow: 1px 1px 2px #2E828B; 
    }

</style>