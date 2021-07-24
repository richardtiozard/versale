<template>
    <div class="componentwarpper">
        <div class="warpper">
            <div class="px-5 d-flex justify-content-between">
                <h4 class="d-inline-block font-weight-600">
                    <i class="fas fa-shipping-fast mr-3"></i>My Orders
                </h4>
            </div>

            <div class="px-5 mt-5">
                <form class="row">
                    <div class="col-8 p-0">
                        <h6 class="col-4 d-inline-block text-right">
                            Search Brand/Product Name:
                        </h6><input v-model="filter.name" type="text" name="name" id='name' class="form-input col-5 d-inline-block" placeholder='Input'>

                        <h6 class="col-4 d-inline-block mt-4 text-right">
                            Status:
                        </h6><select v-model="filter.status" name="status" id='status' class="form-input col-5 d-inline-block">
                            <option value="All"> All </option>
                            <option value="Pending"> Pending </option>
                            <option value="Completed"> Completed </option>
                        </select>
                    </div>
                </form>
                
                <div class="mt-5">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">No.</th>
                                <th scope="col" width="35%">Product(s)</th>
                                <th scope="col" width="30%">Customer Details</th>
                                <th scope="col" class="text-center" width="10%">Order Total</th>
                                <th scope="col" class="text-center" width="15%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in orders" :key="item.order_id">
                                <th class="py-4" scope="row">{{index + 1}}.</th>
                                <td class="py-4">
                                    <div class="row align-items-center">
                                        <img :src="item.product_image" alt="versale product image" class="product-img col-3">
                                        <div class="col-7">
                                            <p>
                                                <span class="font-weight-600">{{ item.product_name }}</span> 
                                                <span class="font-weight-600">({{ item.product_brand }})</span><br/>
                                                <span class="text-7">{{ item.product_description }}</span>
                                            </p>
                                        </div>
                                        <p class="col-1">x{{ item.request_quantity }}</p>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="row align-items-start">
                                        <div class="col-3">
                                            <img :src="item.buyer_image" alt="versale buyer image" class="buyer-img">
                                        </div>
                                        <div class="col-9">
                                                <span class="font-weight-600">{{ item.buyer_username }} </span><br/>
                                                <span class=""><i class="fas fa-phone-alt text-4"></i> (+60) {{ item.buyer_phonenumber }}</span> <br/>
                                                <span class=""><i class="fas fa-map-marker-alt text-4"></i> {{ item.buyer_country }}, {{ item.buyer_city }}, </span> <br/>
                                                <span class="">&nbsp;&nbsp;&nbsp;&nbsp;{{ item.buyer_address }}, {{ item.buyer_zipcode }}</span><br/>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center py-4"> RM{{item.payment_amount}} </td>
                                <td v-if="item.order_status == 'Completed'" class="text-center text-3 py-4"><i class="fas fa-check"></i> {{item.order_status}} </td>
                                <td @click="openConfirmModal(item)" v-if="item.order_status == 'Pending'" class="text-center text-3 py-4 cursor-pointer"><i class="fas fa-edit"></i> {{item.order_status}} </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="orders==''" class="text-7 w-100 text-center">
                        <img :src="'../img/illustrator/emptyview.png'" class="pointer-events-none empty-img" alt="">
                        <p>No orders found.</p>
                    </div>
                </div>
                

            </div>
        </div>

        <confirm-modal v-if="toggleConfirmModal" @confirmed="completeOrder" @closeConfirmModal="closeConfirmModal" :title="confirmModalTitle"></confirm-modal>
        <Rating v-if="toggleRating" @confirmed="rateBuyer" @closeRating="closeRating"></Rating>
    </div>
    
</template>

<script>

import ConfirmModal from '../../template/ConfirmModal.vue';
import Rating from '../../template/Rating.vue';

export default {
    components:{
        ConfirmModal,
        Rating
    },
    props: [
        'data'
    ],
    data(){
        return{
            orders: this.data.orders,

            filter:{
                name: '',
                status: 'All',
            },

            selected_order: '',
            toggleConfirmModal: false,
            toggleRating: false,
            confirmModalTitle: '',
        }
    },
    methods:{

        /* RATE BUYER */
        rateBuyer(rating, message){
            axios.put('/seller/orders',{ 
                'order_id': this.selected_order.order_id, 
                'product_id': this.selected_order.product_id, 
                'request_quantity': this.selected_order.request_quantity, 
                'rating': rating, 
                'message': message,
                'buyer_id': this.selected_order.buyer_id
            })
            .then( response => {
                console.log(response.data);
                this.closeConfirmModal();
                window.location.href = "/seller/orders";
            })
            .catch ( error => {
                console.log(error.response.data);
            })
        },
        openRating(){
            this.toggleRating = true;
            document.body.style.overflow = 'hidden';
        },
        closeRating(){
            this.toggleRating = false;
            document.body.style.overflow = 'auto';
        },

        /* COMPLETE ORDER */
        openConfirmModal(order){
            this.selected_order = order;
            this.confirmModalTitle = "Are you sure you have completed your delivery?";
            this.toggleConfirmModal = true;
            document.body.style.overflow = 'hidden';
        },
        closeConfirmModal(){
            this.toggleConfirmModal = false;
            document.body.style.overflow = 'auto';
        },
        completeOrder(){
            this.closeConfirmModal();
            this.openRating();
        },

        /* FILTER ORDERS */
        filterData(){
            var filtereddata = [];
            if( this.filter.status == 'All'){
                for( var item in this.data.orders){
                    if (this.data.orders[item].product_name.toLowerCase().includes(this.filter.name.toLowerCase()) || this.data.orders[item].product_brand.toLowerCase().includes(this.filter.name.toLowerCase())){
                        filtereddata.push(this.data.orders[item]);
                    }
                }
                this.orders = filtereddata;
            }
            else if( this.filter.status != 'All'){
                for( var item in this.data.orders){
                    if ((this.data.orders[item].product_name.toLowerCase().includes(this.filter.name.toLowerCase()) || this.data.orders[item].product_brand.toLowerCase().includes(this.filter.name.toLowerCase())) && this.data.orders[item].order_status.toLowerCase() == this.filter.status.toLowerCase()){
                        filtereddata.push(this.data.orders[item]);
                    }
                }
                this.orders = filtereddata;
            }
        },
    },
    watch:{
        'filter.name': function(newVal, oldVal){
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