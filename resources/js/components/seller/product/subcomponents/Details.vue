<template>
    <div @click.self="closeModal" class="modalwarpper">
        <div class="modal-box p-5">
            <div class="row">
                <h4 class="d-block col-9 font-weight-600">Product Details</h4>
                <div v-if="!toggleRatingState" class="d-block col-3 text-center">
                    <div v-if="!toggleEditState" @click="editState" class="editbutton text-3 cursor-pointer"><i class="fas fa-edit"></i> Edit Product</div>
                    <div v-if="toggleEditState" @click="saveEdit" class="savebutton text-3 cursor-pointer">Save</div>
                </div>
            </div>
            
            <div v-if="isSuccess" class="successmsg p-3 my-2"><i class="fas fa-check text-9 mr-2"></i> Successfully updated the product. </div>
            <div v-if="isError" class="errormsg p-3 my-2"><i class="fas fa-times text-8 mr-2"></i> {{ errortext }}</div>
            <div v-if="isEmpty" class="errormsg p-3 my-2"><i class="fas fa-exclamation text-8 mr-2"></i> Please enter all the required fields. </div>  

            <div class="row mt-5">
                <div class="box-height col-6 text-center">
                    <img :src="imagePreview" alt="" class="prodimg col-12">
                    <div v-if="toggleEditState" class="mt-2 cursor-pointer text-3" @click="selectImage"><i class="fas fa-upload"></i> Upload Image</div> 
                    <input ref="fileInput" type="file" class="d-none" @change="onFileChange">
                    <div @click="toggleRatingState =! toggleRatingState" v-if="!toggleEditState && !toggleRatingState" class="review-button cursor-pointer text-3">Ratings & Reviews <i class="fas fa-chevron-right"></i></div>
                    <div @click="toggleRatingState =! toggleRatingState" v-if="!toggleEditState && toggleRatingState" class="review-button cursor-pointer text-3"><i class="fas fa-chevron-left"></i> Details</div>
                </div>

                <div v-if="!toggleRatingState" class="box-height col-6 details-form">
                    <label for="editname" class="d-block text-7">Name<span v-if="toggleEditState" class="text-8">*</span></label> 
                    <input :value="product.name" ref="nameinput" type="text" name="editname" id='editname' class="form-input" placeholder="Enter your product's title*" required disabled>
                    
                    <label for="editbrand" class="d-block mt-4 text-7">Brand<span v-if="toggleEditState" class="text-8">*</span></label> 
                    <input :value="product.brand" ref="brandinput" type="text" name="editbrand" id='editbrand' class="form-input" placeholder="Enter your product's brand*" required disabled>
                    

                    <div class="row">
                        <div class="col-6">
                            <label for="editstock" class="d-block mt-4 text-7">Stock<span v-if="toggleEditState" class="text-8">*</span></label> 
                            <input :value="product.stock" ref="stockinput" type="number" name="editstock" id='editstock' class="form-input" placeholder="Enter your product's stock*" required disabled>                                
                        </div>

                        <div class="col-6">
                            <label for="editprice" class="d-block mt-4 text-7">Price (MYR)<span v-if="toggleEditState" class="text-8">*</span></label> 
                            <input :value="product.price" ref="priceinput" type="number" name="editprice" id='editprice' class="form-input" placeholder="Enter your product's price*" required disabled>
                        </div>
                    </div>      

                    <label for="editdescription" class="d-block mt-4 text-7">Description<span v-if="toggleEditState" class="text-8">*</span></label> 
                    <textarea :value="product.description" ref="descriptioninput" type="text" name="editdescription" id='editdescription' class="form-input" style="resize: none" placeholder="Enter your product's description*" required disabled></textarea>
                </div>

                <div v-if="toggleRatingState" class="box-height col-6 details-form overflow-y-auto">
                    <h5 class="sticky-top bg-1">{{seller_ratings.length}} Reviews</h5>
                    <div v-for="item in seller_ratings" class="row py-3">
                        <div class="col-3 text-center">
                            <img :src="item.image" alt="versale buyer image" class="buyer_img">
                        </div>
                        <div class="col-9">
                            <div class="">
                                <div class="d-inline-block">{{item.username}}</div>
                                <div class="d-inline-block ml-2" v-if="item.rating == 5" >
                                    <i v-for="index in 5" class="fas fa-star text-rating"></i>
                                </div>
                                <div class="d-inline-block ml-2" v-if="item.rating > 4 && item.rating < 5" >
                                    <i v-for="index in 4" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i>
                                </div>
                                <div class="d-inline-block ml-2" v-if="item.rating == 4" >
                                    <i v-for="index in 4" class="fas fa-star text-rating"></i><i v-for="index in 1" class="far fa-star text-rating"></i>
                                </div>
                                <div class="d-inline-block ml-2" v-if="item.rating > 3 && item.rating < 4" >
                                    <i v-for="index in 3" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 1" class="far fa-star text-rating"></i>
                                </div>
                                <div class="d-inline-block ml-2" v-if="item.rating == 3" >
                                    <i v-for="index in 3" class="fas fa-star text-rating"></i><i v-for="index in 2" class="far fa-star text-rating"></i>
                                </div>
                                <div class="d-inline-block ml-2" v-if="item.rating > 2 && item.rating < 3" >
                                    <i v-for="index in 2" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 2" class="far fa-star text-rating"></i>
                                </div>
                                <div class="d-inline-block ml-2" v-if="item.rating == 2" >
                                    <i v-for="index in 2" class="fas fa-star text-rating"></i><i v-for="index in 3" class="far fa-star text-rating"></i>
                                </div>
                                <div class="d-inline-block ml-2" v-if="item.rating > 1 && item.rating < 2" >
                                    <i v-for="index in 1" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 3" class="far fa-star text-rating"></i>
                                </div>
                                <div class="d-inline-block ml-2" v-if="item.rating == 1" >
                                    <i v-for="index in 1" class="fas fa-star text-rating"></i><i v-for="index in 4" class="far fa-star text-rating"></i>
                                </div>
                                <div class="d-inline-block ml-2" v-if="!item.rating" >
                                    <span class="text-rating"><i>Not Rated</i></span>
                                </div>
                                <div class="text-7">{{item.message}}</div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:[
        'product',
        'seller_ratings'
    ],
    data(){
        return{
            toggleEditState: false,
            toggleRatingState: false,

            editproduct:{
                image: '',
            },
            imagePreview: this.product.image,

            isSuccess: false,
            isError: false,
            isEmpty: false,
            errortext: "",
        }
    },
    methods:{
        /* RATINGS */
        openRating(){
            this.toggleRatingState = true;
        },

        /* DETAILS */
        closeModal(){
            this.$emit('closeProductDetails');
        },
        editState(){
            this.toggleEditState = !this.toggleEditState;
            this.isSuccess= false;
            this.isError= false;
            this.isEmpty= false;
            this.$refs.nameinput.disabled = false;
            this.$refs.brandinput.disabled = false;
            this.$refs.stockinput.disabled = false;
            this.$refs.priceinput.disabled = false;
            this.$refs.descriptioninput.disabled = false;
        },
        saveState(data){
            this.toggleEditState = false;
            this.$refs.nameinput.disabled = true;
            this.$refs.brandinput.disabled = true;
            this.$refs.stockinput.disabled = true;
            this.$refs.priceinput.disabled = true;
            this.$refs.descriptioninput.disabled = true;
            this.editproduct.image = '';
            this.product.name = data.name;
            this.product.brand = data.brand;
            this.product.price = data.price;
            this.product.stock = data.stock;
            this.product.description = data.description;
            this.product.image = data.image;
        },

        /* On Edit State */
        selectImage () {
            this.$refs.fileInput.click()
        },
        onFileChange(e) {
            this.editproduct.image = e.target.files[0];
            this.imagePreview = URL.createObjectURL(this.editproduct.image);
        },
        saveEdit(){
            if(this.$refs.nameinput.value == "" || this.$refs.priceinput.value == "" || this.$refs.stockinput.value == "" || this.$refs.brandinput.value == "" || this.$refs.descriptioninput.value == ""){
                this.isSuccess= false;
                this.isError= false;
                this.isEmpty= true;
            }
            else{
                let formData = new FormData();
                formData.append('id', this.product.id);
                formData.append('name', this.$refs.nameinput.value);
                formData.append('brand', this.$refs.brandinput.value);
                formData.append('description', this.$refs.descriptioninput.value);
                formData.append('price', this.$refs.priceinput.value);
                formData.append('stock', this.$refs.stockinput.value);
                formData.append('image', this.editproduct.image);
                axios.post( '/seller/products/update',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                )
                .then( response => {
                    console.log(response.data)
                    this.isSuccess = true;
                    this.isError = false;
                    this.isEmpty = false;
                    this.saveState(response.data);
                })
                .catch ( error => {
                    console.log(error.response.data);
                    this.isSuccess = false;
                    this.isError = true;
                    this.isEmpty = false;
                    this.errortext = Object.values(error.response.data.errors).flat().join();
                })
            }
        }
    }
}
</script>

<style scoped>
.modalwarpper{
    position: fixed;
    top: 0px;
    right: 0px;
    width: 83%;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.6);

    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-box{
    width: 75%;
    max-width: 800px;
    background-color: white;
    border-radius: 15px;
}
.box-height{
    height: 355px;
}

.prodimg{
    height: 250px;
    object-fit: contain;
}
.buyer_img{
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
}

.details-form .form-input{
    background-color: transparent;
    color: #333333;
    border: 2px solid #999999;
    padding: 5px;
    border-radius: 0;
    width: 100%;
}
.details-form .form-input:focus{
    background-color: transparent;
    color: #333333;
    border: 2px solid #333333;
    padding: 5px;
    border-radius: 0;
    width: 100%;
}
.details-form .form-input:disabled{
    border: 0;
}
.details-form .form-input::placeholder{
    color: #999999;
}

.review-button{
    position: absolute;
    bottom: 0;
    left: 20px;
}

.savebutton {
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
.savebutton:hover {
    box-shadow: inset 0 0 20px rgba(190, 218, 250, .5), 0 0 20px rgba(190, 218, 250, .2);
    outline: 1px solid;
    outline-color: rgba(190, 218, 250, 0);
    outline-offset: 15px;
    text-shadow: 1px 1px 2px #2E828B; 
}

.editbutton {
    cursor: pointer;
    text-align: right;
    line-height: 45px;
    width: 100%;
}
</style>