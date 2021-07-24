<template>
  <div class="componentwarpper">
        <div class="warpper min-vh-100">
            <div class="content-warpper d-flex justify-content-between">
                <h4 class="d-inline-block font-weight-600">Add New Product <span class="text-7 font-weight-200">(Step {{step}}/2)</span></h4>

                <a :href="'/seller/products'">
                    <div class="d-inline-block text-3">
                        My Products <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
            <div v-if="step == 1" class="step1 mt-5">
                
                <h6 class="d-inline-block mr-3">Select Your Product's Category:</h6> 
                <span v-if="chosen_category" class="text-3"> {{chosen_category}} <i class="fas fa-chevron-right mx-2"></i></span>
                <span v-if="chosen_subcategory" class="text-3"> {{chosen_subcategory}} <i class="fas fa-chevron-right mx-2"></i></span>
                <span v-if="chosen_subcategory2" class="text-3"> {{chosen_subcategory2}}</span>

                <div id="category-box" class="d-flex w-100 border mt-3">
                    <div class="w-100 overflow-auto">
                        <ul class="p-0 d-flex flex-column">
                            <li @click="setCategory(category)" v-for="category in getCategories" :key="category" class="single-list list-unstyled p-3 border">
                                <div class="d-inline-block w-50">{{ category }}</div><div class="d-inline-block w-50 text-right"><i class="fas fa-chevron-right"></i></div> 
                            </li>
                        </ul>
                    </div>
                    <div class="w-100 overflow-auto">
                        <ul class="p-0 d-flex flex-column">
                            <li @click="setSubCategory(subcategory)" v-for="subcategory in getSubCategories" :key="subcategory" class="single-list list-unstyled p-3 border">
                                <div class="d-inline-block w-50">{{ subcategory }}</div><div class="d-inline-block w-50 text-right"><i class="fas fa-chevron-right"></i></div> 
                            </li>
                        </ul>
                    </div>
                    <div class="w-100 overflow-auto">
                        <ul class="p-0 d-flex flex-column">
                            <li @click="setSubCategory2(item)" v-for="item in getSubCategories2" :key="item.id" class="single-list list-unstyled p-3 border">
                                <div class="d-inline-block w-50">{{ item.subcategory2 }}</div> 
                            </li>
                        </ul>
                    </div>
                </div>

                <div v-if="!chosen_subcategory2" class="next-disable-button">Next</div>
                <div v-else @click="nextStep" class="next-button">Next</div>

            </div>

            <div v-else-if="step == 2" class="step2 mt-5">
                <h6>Enter Your Product's Details:</h6> 
                <span v-if="chosen_category" class="text-3"> {{chosen_category}} <i class="fas fa-chevron-right mx-2"></i></span>
                <span v-if="chosen_subcategory" class="text-3"> {{chosen_subcategory}} <i class="fas fa-chevron-right mx-2"></i></span>
                <span v-if="chosen_subcategory2" class="text-3"> {{chosen_subcategory2}}</span>

                <div class="row">
                    <div class="d-inline-flex flex-column col-6 justify-content-center align-items-center">
                        <img id="product-image" :src="preview_product_img" alt="product image" class="cursor-pointer" @click="selectImage">
                        <p class="mt-2 cursor-pointer" @click="selectImage">Upload Image</p> 
                        <input ref="fileInput" type="file" class="d-none" @change="onFileChange">
                    </div>
                    <form class="col-6">

                        <div v-if="isSuccess" class="successmsg p-3 my-4"><i class="fas fa-check text-9 mr-2"></i> Successfully listed the product. </div>
                        <div v-if="isError" class="errormsg p-3 my-4"><i class="fas fa-times text-8 mr-2"></i> {{ errortext }}</div>
                        <div v-if="isEmpty" class="errormsg p-3 my-4"><i class="fas fa-exclamation text-8 mr-2"></i> Please enter all the required fields and upload your product's image. </div>    

                        <label for="name" class="d-block mt-4 text-7">Name<span class="text-8">*</span></label> 
                        <input v-model="product.name" type="text" name="name" id='name' class="form-input" placeholder="Enter your product's title*" required autofocus>
                        
                        <label for="brand" class="d-block mt-4 text-7">Brand<span class="text-8">*</span></label> 
                        <input v-model="product.brand" type="text" name="brand" id='brand' class="form-input" placeholder="Enter your product's brand*" required>
                        
                        <label for="description" class="d-block mt-4 text-7">Description<span class="text-8">*</span></label> 
                        <input v-model="product.description" type="text" name="description" id='description' class="form-input" placeholder="Enter your product's description*" required>
                        
                        <div class="row">
                            <div class="col-6">
                                <label for="stock" class="d-block mt-4 text-7">Stock<span class="text-8">*</span></label> 
                                <input v-model="product.stock" type="number" name="stock" id='stock' class="form-input" placeholder="Enter your product's stock*" required>                                
                            </div>

                            <div class="col-6">
                                <label for="price" class="d-block mt-4 text-7">Price<span class="text-8">*</span></label> 
                                <input v-model="product.price" type="number" name="price" id='price' class="form-input" placeholder="Enter your product's price*" required>
                            </div>
                        </div>

                    
                        <div @click="submitRequest" class="submit-button d-inline-block w-50">Submit</div>
                        <div @click="clearFields" class="clear-button d-inline-block w-50">Clear</div>

                    </form> 
                </div>
                <div @click="prevStep" class="d-inline-block position-absolute back-button text-3"><i class="fas fa-arrow-left"></i> Back</div>

            </div>

        </div>
    </div>
</template>

<script>

export default {
    props: ['categories'],
    data(){
        return{
            step: 1,

            chosen_category:"",
            chosen_subcategory:"",
            chosen_subcategory2:"",

            preview_product_img: '../../img/illustrator/uploadimage.png',

            product: {
                name:"",
                brand:"",
                description:"",
                stock:"",
                price:"",
                image: "",
                category: "",
            },
            

            isSuccess: false,
            isError: false,
            isEmpty: false,
            errortext: "",
        }
    },
    methods:{

        nextStep(){
            this.step += 1;
            this.isSuccess = false;
            this.isError = false;
            this.isEmpty = false;
            this.errortext = "";
        },
        prevStep(){
            this.step -= 1;
            this.isSuccess = false;
            this.isError = false;
            this.isEmpty = false;
            this.errortext = "";
        },

        setCategory( category ){
            this.chosen_category = category;
            this.chosen_subcategory = "";
            this.chosen_subcategory2 = "";
        },
        setSubCategory( subcategory ){
            this.chosen_subcategory = subcategory;
            this.chosen_subcategory2 = "";
        },
        setSubCategory2( item ){
            this.chosen_subcategory2 = item.subcategory2;
            this.product.category = item;
        },

        selectImage () {
            this.$refs.fileInput.click()
        },
        onFileChange(e) {
            this.product.image = e.target.files[0];
            this.preview_product_img = URL.createObjectURL(this.product.image);
        },

        submitRequest(){
            if(this.product.name == "" || this.product.brand == "" || this.product.description == "" || this.product.stock == "" || this.product.price == "" || this.product.image == ""){
                this.isSuccess= false;
                this.isError= false;
                this.isEmpty= true;
            }
            else{
                let formData = new FormData();
                formData.append('name', this.product.name);
                formData.append('brand', this.product.brand);
                formData.append('description', this.product.description);
                formData.append('price', this.product.price);
                formData.append('stock', this.product.stock);
                formData.append('image', this.product.image);
                formData.append('category_id', this.product.category.id);
                axios.post( '/seller/products/create',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                )
                .then( response => {
                    this.product.name = '';
                    this.product.brand = '';
                    this.product.description = '';
                    this.product.price = '';
                    this.product.stock = '';
                    this.product.image = '';
                    this.preview_product_img = '../../img/illustrator/uploadimage.png';
                    this.isSuccess = true;
                    this.isError = false;
                    this.isEmpty = false;
                })
                .catch ( error => {
                    console.log(error.response.data);
                    this.isSuccess = false;
                    this.isError = true;
                    this.isEmpty = false;
                    this.errortext = Object.values(error.response.data.errors).flat().join();
                })
            }
        },

        clearFields(){
            this.product.name = "";
            this.product.description = "";
            this.product.brand = "";
            this.product.stock = "";
            this.product.price = "";
        }


    },
    computed:{
        getCategories(){
            return new Set(this.categories.map(x => x.category));
        },
        getSubCategories(){
            var arr = [];
            for (var item in this.categories){
                if( this.categories[item].category == this.chosen_category){
                    arr.push(this.categories[item]);
                }
            }
            return new Set(arr.map(x => x.subcategory));
        },
        getSubCategories2(){
            var arr = [];
            for (var item in this.categories){
                if( this.categories[item].category == this.chosen_category && this.categories[item].subcategory == this.chosen_subcategory){
                    arr.push(this.categories[item]);
                }
            }
            return arr;        
        },
    },
    mounted(){

    }
}
</script>

<style scoped>

    .content-warpper{
        width: 90%;
        margin: 0 auto;
    }
    /* PAGE ! */
    .step1{
        width: 90%;
        margin: 0 auto;
    }
    #category-box{
        height: 50vh;
    }

    .single-list{
        cursor: pointer;
    }
    .single-list:hover,
    .single-list.active,
    .single-list.focus{
        color: #FCFAF1;
        background-color: #134153;
    }

    .next-disable-button{
        float: right;
        cursor: not-allowed;
        text-align: center;
        line-height: 45px;
        margin-top: 25px;
        max-width: 160px;
        width: 100%; 
        color: #FCFAF1;
        background-color: #999999;
    }
    .next-button,
    .submit-button {
        cursor: pointer;
        text-align: center;
        line-height: 45px;
        width: 100%; 
        color: #FCFAF1;
        background-color: rgba(19, 65, 83, 1);

        box-shadow: inset 0 0 20px rgba(190, 218, 250, 0);
        outline-color: rgba(19, 65, 83, .5);
        outline-offset: 0px;
        text-shadow: none;
        transition: all 1250ms cubic-bezier(0.19, 1, 0.22, 1);
    }
    .next-button{
        float: right;
        max-width: 160px;
        margin-top: 25px;
    }
    .next-button:hover,
    .submit-button:hover {
        box-shadow: inset 0 0 20px rgba(190, 218, 250, .5), 0 0 20px rgba(190, 218, 250, .2);
        outline: 1px solid;
        outline-color: rgba(190, 218, 250, 0);
        outline-offset: 15px;
        text-shadow: 1px 1px 2px #2E828B; 
    }

    


    /* PAGE 2 */
    .step2{
        width: 90%;
        margin: 0 auto;
    }
    #product-image{
        width: 350px;
        height: 250px;
        object-fit: contain;
    }

    .form-input{
        background-color: transparent;
        color: #333333;
        border: 2px solid #999999;
        padding: 5px;
        border-radius: 0;
        width: 100%;
    }
    .form-input:focus{
        color: #333333;
        border: 2px solid #333333;
    }
    .form-input:focus {
        color: #333333;
        border: 2px solid #333333;
    }

    .form-input::placeholder{
        color: #999999;
    }

    .submit-button{
        float: left;
        margin-top: 35px;
    }

    .clear-button {
        float: right;
        cursor: pointer;
        text-align: center;
        line-height: 45px;
        margin-top: 35px;
        width: 100%; 
        color: #E40041;
        background-color: transparent;

        box-shadow: inset 0 0 20px rgba(190, 218, 250, 0);
        outline-color: rgba(19, 65, 83, .5);
        outline-offset: 0px;
        text-shadow: none;
        transition: all 1250ms cubic-bezier(0.19, 1, 0.22, 1);
    }
    .clear-button:hover {
        box-shadow: inset 0 0 20px rgba(190, 218, 250, .5), 0 0 20px rgba(190, 218, 250, .2);
        outline: 1px solid;
        outline-color: rgba(190, 218, 250, 0);
        outline-offset: 15px;
        text-shadow: 1px 1px 2px #2E828B; 
    }

    .back-button{
        margin-top: -30px;
        cursor: pointer;
    }

</style>