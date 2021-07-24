<template>
    <div class="componentwarpper">
        <div class="warpper">
            <div class="px-5 d-flex justify-content-between">
                <h4 class="d-inline-block font-weight-600">
                    <i class="fas fa-box-open mr-3"></i>My Products
                </h4>
                <a :href="'/seller/products/create'">
                    <div class="d-inline-block text-3">
                        Add New Products <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>

            <div class="px-5 mt-5">
                <form class="row">
                    <div class="col-6 p-0">
                        <h6 class="col-4 d-inline-block text-right">
                            Search Product Name:
                        </h6><input v-model="filter.name" type="text" name="name" id='name' class="form-input col-8 d-inline-block" placeholder='Input'>

                        <h6 class="col-4 d-inline-block mt-4 text-right">
                            Brand:
                        </h6><select v-model="filter.brand" name="brand" id='brand' class="form-input col-8 d-inline-block">
                            <option value="All"> All </option>
                            <option v-for="item in data.brands" :value="item.brand">{{ item.brand }}</option>
                        </select>
                    </div>
                    <div class="col-6 p-0">
                        <h6 class="col-4 d-inline-block text-right">
                            Category:
                        </h6><select v-model="filter.category" name="category" id='category' class="form-input col-8 d-inline-block">
                            <option value="All"> All </option>
                            <option v-for="item in data.categories" :value="item.category">{{ item.category }}</option>
                        </select>
                    </div>
                </form>
                
                <div class="mt-5">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">No.</th>
                                <th scope="col" width="15%">Name</th>
                                <th scope="col" width="15%">Brand</th>
                                <th scope="col" width="15%">Category</th>
                                <th scope="col" width="20">Description</th>
                                <th scope="col" width="10%" class="text-center">Stock</th>
                                <th scope="col" width="10%" class="text-center">Price (MYR)</th>
                                <th scope="col" width="10%" class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in products" :key="item.id" class="cursor-pointer">
                                <th scope="row" @click.self="showDetails(item.id)">{{index + 1}}.</th>
                                <td @click.self="showDetails(item)"> {{item.name}} </td>
                                <td @click.self="showDetails(item)"> {{item.brand}} </td>
                                <td @click.self="showDetails(item)"> {{item.subcategory2}} </td>
                                <td @click.self="showDetails(item)"> {{item.description}} </td>
                                <td class="text-center" @click.self="showDetails(item)"> {{item.stock}} </td>
                                <td class="text-center" @click.self="showDetails(item)"> {{item.price}} </td>
                                <td class="text-center">
                                    <i @click="openConfirmDeleteModal(item)" class="fas fa-trash-alt text-5 cursor-pointer"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="products==''" class="text-7 w-100 text-center">
                        <img :src="'../img/illustrator/emptyview.png'" class="pointer-events-none empty-img" alt="">
                        <p>No products found.</p>
                    </div>
                </div>
                

            </div>
        </div>

        <confirm-modal v-if="toggleConfirmModal" @confirmed="deleteProduct" @closeConfirmModal="closeConfirmModal" :title="confirmModalTitle"></confirm-modal>
        <product-details v-if="toggleProductDetails" :product="selectedProduct" :seller_ratings="selected_seller_ratings" @closeProductDetails="closeDetails"></product-details>
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
            products: this.data.products,

            filter:{
                name: '',
                brand: 'All',
                category: 'All'
            },

            selected_product_id: '',
            

            toggleProductDetails: false,
            selectedProduct: '',
            selected_seller_ratings: '',

            toggleConfirmModal: false,
            confirmModalTitle: '',
        }
    },
    methods:{

        /* PRODUCT DETAILS */
        showDetails(product){
            this.selectedProduct = product;

            var arr= [];
            for(var i in this.data.seller_ratings){
                if(this.data.seller_ratings[i].product_id == this.selectedProduct.id){
                    arr.push(this.data.seller_ratings[i]);
                }
            }
            this.selected_seller_ratings = arr;
            
            this.toggleProductDetails = true;
            document.body.style.overflow = 'hidden';
        },
        closeDetails(){
            this.selectedProduct = '';
            this.toggleProductDetails = false;
            document.body.style.overflow = 'auto';
        },

        /* DELETE PRODUCT */
        openConfirmDeleteModal(product){
            this.selected_product_id = product.id;
            this.confirmModalTitle = "Are you sure you want to delete " + product.name + "?";
            this.toggleConfirmModal = true;
            document.body.style.overflow = 'hidden';
        },
        closeConfirmModal(){
            this.toggleConfirmModal = false;
            document.body.style.overflow = 'auto';
        },
        deleteProduct(){
            axios.delete('/seller/products',{ 
                data: { 
                    product_id: this.selected_product_id 
                } 
            })
            .then( response => {
                console.log(response.data);
                this.closeConfirmModal();
                window.location.href = "/seller/products";
            })
            .catch ( error => {
                console.log(error.response.data);
            })
        },

        /* FILTER PRODUCT */
        filterProduct(){
            var filteredprod = [];
            if( this.filter.brand == 'All' && this.filter.category == 'All' ){
                for( var product in this.data.products){
                    if (this.data.products[product].name.toLowerCase().includes(this.filter.name.toLowerCase())){
                        filteredprod.push(this.data.products[product]);
                    }
                }
                this.products = filteredprod;
            }
            else if( this.filter.brand != 'All' && this.filter.category == 'All' ){
                for( var product in this.data.products){
                    if (this.data.products[product].name.toLowerCase().includes(this.filter.name.toLowerCase()) && this.data.products[product].brand.toLowerCase() == this.filter.brand.toLowerCase()){
                        filteredprod.push(this.data.products[product]);
                    }
                }
                this.products = filteredprod;
            }
            else if( this.filter.brand == 'All' && this.filter.category != 'All' ){
                for( var product in this.data.products){
                    if (this.data.products[product].name.toLowerCase().includes(this.filter.name.toLowerCase()) && this.data.products[product].subcategory2.toLowerCase() == this.filter.category.toLowerCase()){
                        filteredprod.push(this.data.products[product]);
                    }
                }
                this.products = filteredprod;
            }
            else if( this.filter.brand != 'All' && this.filter.category != 'All' ){
                for( var product in this.data.products){
                    if (this.data.products[product].name.toLowerCase().includes(this.filter.name.toLowerCase()) && this.data.products[product].brand.toLowerCase() == this.filter.brand.toLowerCase() && this.data.products[product].subcategory2.toLowerCase() == this.filter.category.toLowerCase()){
                        filteredprod.push(this.data.products[product]);
                    }
                }
                this.products = filteredprod;
            }
        },
    },
    watch:{
        'filter.name': function(newVal, oldVal){
            this.filterProduct();
        },
        'filter.brand': function(newVal, oldVal){
            this.filterProduct();
        },
        'filter.category': function(newVal, oldVal){
            this.filterProduct();
        },
    },
    mounted(){
        console.log(this.data);
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