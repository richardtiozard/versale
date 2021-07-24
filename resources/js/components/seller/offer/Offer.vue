<template>
    <div class="componentwarpper">
        <div class="warpper">
            <div class="px-5 d-flex justify-content-between">
                <h4 class="d-inline-block font-weight-600">
                    <i class="fas fa-hand-holding-usd mr-3"></i> Offers
                </h4>
            </div>

            <div class="px-5 mt-5">
                <form class="row">
                    <div class="col-6 p-0">
                        <h6 class="col-4 d-inline-block text-right">
                            Search Product Name:
                        </h6><input v-model="filter.name" type="text" name="name" id='name' class="form-input col-8 d-inline-block" placeholder='Input'>

                        <h6 class="col-4 d-inline-block mt-4 text-right">
                            Status:
                        </h6><select v-model="filter.status" name="status" id='status' class="form-input col-8 d-inline-block">
                            <option value="All"> All </option>
                            <option value="Pending"> Pending </option>
                            <option value="Accepted"> Accepted </option>
                        </select>
                    </div>
                    <div class="col-6 p-0">
                        <h6 class="col-4 d-inline-block text-right">
                            Request Status:
                        </h6><select v-model="filter.request_status" name="category" id='category' class="form-input col-8 d-inline-block">
                            <option value="All"> All </option>
                            <option value="Available"> Available </option>
                            <option value="Not Available"> Not Available </option>
                        </select>
                    </div>
                </form>
                
                <div class="mt-5">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">No.</th>
                                <th scope="col" width="15%">Product Name</th>
                                <th scope="col" width="15%">Brand</th>
                                <th scope="col" width="15%">Category</th>
                                <th scope="col" class="text-center" width="10%">Quantity</th>
                                <th scope="col" class="text-center" width="10%">Price (MYR)</th>
                                <th scope="col" class="text-center" width="15%">Status</th>
                                <th scope="col" class="text-center" width="15%">Request Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in offers" :key="item.id" @click="redirect(item.request_id)" class="cursor-pointer">
                                <th scope="row">{{index + 1}}.</th>
                                <td> {{item.name}} </td>
                                <td> {{item.brand}} </td>
                                <td> {{item.subcategory2}} </td>
                                <td class="text-center"> {{item.quantity}} </td>
                                <td class="text-center"> {{item.price}} </td>
                                <td class="text-center text-3"> {{item.offer_status}} </td>
                                <td class="text-center text-3"> {{item.request_status}} </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="offers==''" class="text-7 w-100 text-center">
                        <img :src="'../img/illustrator/emptyview.png'" class="pointer-events-none empty-img" alt="">
                        <p>No offers found.</p>
                    </div>
                </div>
                

            </div>
        </div>
    </div>
    
</template>

<script>


export default {
    components:{
    },
    props: [
        'data'
    ],
    data(){
        return{
            offers: this.data.offers,

            filter:{
                name: '',
                status: 'All',
                request_status: 'All'
            },
        }
    },
    methods:{

        /* REDIRECT TO REQUEST DETAILS*/
        redirect(request_id){
            window.location.href = "/seller/requests/"+request_id;
        },

        /* FILTER OFFERS */
        filterData(){
            var filtereddata = [];
            if( this.filter.status == 'All' && this.filter.request_status == 'All' ){
                for( var item in this.data.offers){
                    if (this.data.offers[item].name.toLowerCase().includes(this.filter.name.toLowerCase())){
                        filtereddata.push(this.data.offers[item]);
                    }
                }
                this.offers = filtereddata;
            }
            else if( this.filter.status != 'All' && this.filter.request_status == 'All' ){
                for( var item in this.data.offers){
                    if (this.data.offers[item].name.toLowerCase().includes(this.filter.name.toLowerCase()) && this.data.offers[item].offer_status.toLowerCase() == this.filter.status.toLowerCase()){
                        filtereddata.push(this.data.offers[item]);
                    }
                }
                this.offers = filtereddata;
            }
            else if( this.filter.status == 'All' && this.filter.request_status != 'All' ){
                for( var item in this.data.offers){
                    if (this.data.offers[item].name.toLowerCase().includes(this.filter.name.toLowerCase()) && this.data.offers[item].request_status.toLowerCase() == this.filter.request_status.toLowerCase()){
                        filtereddata.push(this.data.offers[item]);
                    }
                }
                this.offers = filtereddata;
            }
            else if( this.filter.status != 'All' && this.filter.request_status != 'All' ){
                for( var item in this.data.offers){
                    if (this.data.offers[item].name.toLowerCase().includes(this.filter.name.toLowerCase()) && this.data.offers[item].offer_status.toLowerCase() == this.filter.status.toLowerCase() && this.data.offers[item].request_status.toLowerCase() == this.filter.request_status.toLowerCase()){
                        filtereddata.push(this.data.offers[item]);
                    }
                }
                this.offers = filtereddata;
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
        'filter.request_status': function(newVal, oldVal){
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
</style>