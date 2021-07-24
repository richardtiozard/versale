<template>
    <div class="componentwarpper">
        <div class="warpper">
            <div class="px-5 d-flex justify-content-between">
                <h4 class="d-inline-block font-weight-600">
                    <i class="fas fa-users"></i> Manage Users
                </h4>
                <a :href="'/admin/users/register'">
                    <div class="d-inline-block text-3">
                        Register New Admin <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>

            <div class="px-5 mt-5">
                <form class="row">
                    <div class="col-6 p-0">
                        <h6 class="col-4 d-inline-block text-right">
                            Search by Name:
                        </h6><input v-model="filter.name" type="text" name="name" id='name' class="form-input col-8 d-inline-block" placeholder='Input'>

                        <h6 class="col-4 d-inline-block mt-4 text-right">
                            Role:
                        </h6><select v-model="filter.role" name="role" id='role' class="form-input col-8 d-inline-block">
                            <option value="All"> All </option>
                            <option v-for="item in data.roles" :value="item.role">{{ item.role }}</option>
                        </select>
                    </div>
                    <div class="col-6 p-0">
                        <h6 class="col-4 d-inline-block text-right">
                            Status:
                        </h6><select v-model="filter.status" name="status" id='status' class="form-input col-8 d-inline-block">
                            <option value="All"> All </option>
                            <option v-for="item in data.status" :value="item.status">{{ item.status }}</option>
                        </select>
                    </div>
                </form>
                
                <div class="mt-5">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">No.</th>
                                <th scope="col" width="25%">Full Name</th>
                                <th scope="col" width="15%">Username</th>
                                <th scope="col" width="20%">Email</th>
                                <th scope="col" width="15">Phone Number</th>
                                <th scope="col" width="10%">Role</th>
                                <th scope="col" width="10%" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in users" class="cursor-pointer">
                                <th scope="row" @click.self="showDetails(item.user_id)">{{index + 1}}.</th>
                                <td @click.self="showDetails(item)"> {{item.fullname}} </td>
                                <td @click.self="showDetails(item)"> {{item.username}} </td>
                                <td @click.self="showDetails(item)"> {{item.user_email}} </td>
                                <td @click.self="showDetails(item)">+60 {{item.phonenumber}} </td>
                                <td @click.self="showDetails(item)"> {{item.user_role}} </td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input @change="toggleUserStatus(item.user_id)" type="checkbox" class="custom-control-input" :id="item.user_id" :value="item.user_id" v-model="active_users">
                                        <label class="custom-control-label" :for="item.user_id"></label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="users==''" class="text-7 w-100 text-center">
                        <img :src="'../img/illustrator/emptyview.png'" class="pointer-events-none empty-img" alt="">
                        <p>No users found.</p>
                    </div>
                </div>
                

            </div>
        </div>

        <product-details v-if="toggleUserDetails" :data="selectedUserData" :reviews="selectedReviewsData" @closeDetails="closeDetails"></product-details>
    </div>
    
</template>

<script>

import ConfirmModal from '../../template/ConfirmModal.vue';
import ProductDetails from './subcomponents/Details.vue';

export default {
    components:{
        ConfirmModal,
        ProductDetails
    },
    props: [
        'data'
    ],
    data(){
        return{
            allusers: [],
            users: [],
            active_users: [],

            filter:{
                name: '',
                role: 'All',
                status: 'All'
            },
            
            toggleUserDetails: false,
            selectedUserData: '',
            selectedReviewsData: '',
        }
    },
    methods:{

        /* PRODUCT DETAILS */
        showDetails(user){
            this.selectedUserData = user;

            var arr = [];
            if ( user.user_role.toLowerCase() == 'seller'){
                for ( var i in this.data.seller_ratings ){
                    if (user.user_id == this.data.seller_ratings[i].user_id){
                        arr.push(this.data.seller_ratings[i]);
                    }
                }
                this.selectedReviewsData = arr;
            }
            else if ( user.user_role.toLowerCase() == 'buyer'){
                for ( var i in this.data.buyer_ratings ){
                    if (user.user_id == this.data.buyer_ratings[i].user_id){
                        arr.push(this.data.buyer_ratings[i]);
                    }
                }
                this.selectedReviewsData = arr;
            }
            else{
                this.selectedReviewsData = arr;
            }

            this.toggleUserDetails = true;
            document.body.style.overflow = 'hidden';
        },
        closeDetails(){
            this.selectedUserData = '';
            this.toggleUserDetails = false;
            document.body.style.overflow = 'auto';
        },

        /* TOGGLE USER STATUS */
        toggleUserStatus(userid){
            var toggle = this.active_users.includes(userid);
            var status = '';
            if (toggle){
                status = 'Active';
            }
            else{
                status = 'Inactive';
            }
            axios.put('/admin/users',{ 
                'user_id': userid, 
                'user_status': status
            })
            .then( response => {
                console.log(response.data);
            })
            .catch ( error => {
                console.log(error.response.data);
            })
        },

        /* FILTER USERS */
        filterUsers(){
            var filteredData = [];
            if( this.filter.role == 'All' && this.filter.status == 'All' ){
                for( var user in this.allusers){
                    if (this.allusers[user].fullname.toLowerCase().includes(this.filter.name.toLowerCase())){
                        filteredData.push(this.allusers[user]);
                    }
                }
                this.users = filteredData;
            }
            else if( this.filter.role != 'All' && this.filter.status == 'All' ){
                console.log(this.filter.role)
                for( var user in this.allusers){
                    if (this.allusers[user].fullname.toLowerCase().includes(this.filter.name.toLowerCase()) && this.allusers[user].user_role.toLowerCase() == this.filter.role.toLowerCase()){
                        filteredData.push(this.allusers[user]);
                    }
                }
                this.users = filteredData;
            }
            else if( this.filter.role == 'All' && this.filter.status != 'All' ){
                for( var user in this.allusers){
                    if (this.allusers[user].fullname.toLowerCase().includes(this.filter.name.toLowerCase()) && this.allusers[user].user_status.toLowerCase() == this.filter.status.toLowerCase()){
                        filteredData.push(this.allusers[user]);
                    }
                }
                this.users = filteredData;
            }
            else if( this.filter.role != 'All' && this.filter.status != 'All' ){
                for( var user in this.allusers){
                    if (this.allusers[user].fullname.toLowerCase().includes(this.filter.name.toLowerCase()) && this.allusers[user].user_role.toLowerCase() == this.filter.role.toLowerCase() && this.allusers[user].user_status.toLowerCase() == this.filter.status.toLowerCase()){
                        filteredData.push(this.allusers[user]);
                    }
                }
                this.users = filteredData;
            }
        },
    },
    watch:{
        'filter.name': function(newVal, oldVal){
            this.filterUsers();
        },
        'filter.role': function(newVal, oldVal){
            this.filterUsers();
        },
        'filter.status': function(newVal, oldVal){
            this.filterUsers();
        },
    },
    mounted(){
        console.log(this.data);
        for (var i in this.data.admins){
            this.users.push(this.data.admins[i]);
            this.allusers.push(this.data.admins[i]);
            if (this.data.admins[i].user_status == 'Active'){
                this.active_users.push(this.data.admins[i].user_id);
            }
        }
        for (var i in this.data.sellers){
            this.users.push(this.data.sellers[i]);
            this.allusers.push(this.data.sellers[i]);
            if (this.data.sellers[i].user_status == 'Active'){
                this.active_users.push(this.data.sellers[i].user_id);
            }
        }
        for (var i in this.data.buyers){
            this.users.push(this.data.buyers[i]);
            this.allusers.push(this.data.buyers[i]);
            if (this.data.buyers[i].user_status == 'Active'){
                this.active_users.push(this.data.buyers[i].user_id);
            }
        }
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
</style>