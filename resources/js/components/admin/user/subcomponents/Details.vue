<template>
    <div @click.self="closeModal" class="modalwarpper">
        <div class="modal-box p-5">
            <h4 class="d-block font-weight-600">User Details</h4>

            <div class="row mt-5">
                <div class="row col-12 align-items-start">
                    <div class="col-2"><img :src="data.image" alt="versale" class="userimg shadow-sm"></div>
                    <div class="col-10 row">
                        <h6 class="font-weight-600 col-12">{{data.fullname}} <i v-if="data.gender == 'male'" class="fas fa-mars text-male"></i><i v-if="data.gender == 'female'" class="fas fa-venus text-female"></i> <span class="bg-4 text-1 font-weight-400 px-3 py-1 ml-3 rounded">{{data.user_role}}</span></h6>
                        <div class="col-6">
                            <div class="mt-3"><i class="fas fa-phone-alt text-3"></i> (+60) {{data.phonenumber}}</div>
                            <div class="mt-1"><i class="far fa-envelope text-3"></i> {{data.user_email}}</div>
                        </div>
                        <div class="col-6">
                            <div class="mt-3"><i class="fas fa-map-marker-alt text-3"></i> {{data.country}}, {{data.city}}</div>
                            <div class="mt-1 ml-3">{{data.address}}, {{data.zipcode}}</div>
                        </div>
                    </div>


                </div>
                <hr class="w-100 my-4">
                <div class="col-12">
                    <h5 class="font-weight-200">Rating & Reviews</h5>
                    <div id="review-box" class="row overflow-y-auto">
                        <div v-for="item in reviews" class="col-12 row py-3">
                            <div class="col-2 text-center"><img :src="item.rater_image" alt="versale" class="raterimg shadow-sm"></div>
                            <div class="col-10">
                                <div>
                                    <div class="d-inline-block">{{item.rater_username}}</div>
                                    <div class="d-inline-block ml-2" v-if="item.rating_rating == 5" >
                                        <i v-for="index in 5" class="fas fa-star text-rating"></i>
                                    </div>
                                    <div class="d-inline-block ml-2" v-if="item.rating_rating > 4 && item.rating_rating < 5" >
                                        <i v-for="index in 4" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i>
                                    </div>
                                    <div class="d-inline-block ml-2" v-if="item.rating_rating == 4" >
                                        <i v-for="index in 4" class="fas fa-star text-rating"></i><i v-for="index in 1" class="far fa-star text-rating"></i>
                                    </div>
                                    <div class="d-inline-block ml-2" v-if="item.rating_rating > 3 && item.rating_rating < 4" >
                                        <i v-for="index in 3" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 1" class="far fa-star text-rating"></i>
                                    </div>
                                    <div class="d-inline-block ml-2" v-if="item.rating_rating == 3" >
                                        <i v-for="index in 3" class="fas fa-star text-rating"></i><i v-for="index in 2" class="far fa-star text-rating"></i>
                                    </div>
                                    <div class="d-inline-block ml-2" v-if="item.rating_rating > 2 && item.rating_rating < 3" >
                                        <i v-for="index in 2" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 2" class="far fa-star text-rating"></i>
                                    </div>
                                    <div class="d-inline-block ml-2" v-if="item.rating_rating == 2" >
                                        <i v-for="index in 2" class="fas fa-star text-rating"></i><i v-for="index in 3" class="far fa-star text-rating"></i>
                                    </div>
                                    <div class="d-inline-block ml-2" v-if="item.rating_rating > 1 && item.rating_rating < 2" >
                                        <i v-for="index in 1" class="fas fa-star text-rating"></i><i v-for="index in 1" class="fas fa-star-half-alt text-rating"></i><i v-for="index in 3" class="far fa-star text-rating"></i>
                                    </div>
                                    <div class="d-inline-block ml-2" v-if="item.rating_rating == 1" >
                                        <i v-for="index in 1" class="fas fa-star text-rating"></i><i v-for="index in 4" class="far fa-star text-rating"></i>
                                    </div>
                                    <div class="d-inline-block ml-2" v-if="!item.rating_rating" >
                                        <span class="text-rating"><i>Not Rated</i></span>
                                    </div>
                                </div>
                                <div class="text-7">{{item.rating_message}}</div>
                            </div>
                        </div>
                        <div v-if="reviews==''" class="text-7 w-100 text-center">
                            <img :src="'../img/illustrator/emptyview.png'" class="pointer-events-none empty-img" alt="">
                            <p>No reviews to be shown.</p>
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
        'data','reviews'
    ],
    data(){
        return{

        }
    },
    methods:{
        /* RATINGS */
        openRating(){
            this.toggleRatingState = true;
        },

        /* DETAILS */
        closeModal(){
            this.$emit('closeDetails');
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
    },
    mounted(){
        console.log(this.data)
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
    z-index: 1;
}

.modal-box{
    width: 75%;
    max-width: 800px;
    background-color: white;
    border-radius: 15px;
}

.userimg{
    width: 75px;
    height: 75px;
    border-radius: 50%;
    object-fit: cover;
}
.raterimg{
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}
.empty-img{
    opacity: 0.8;
}

#review-box{
    max-height: 30vh;
}
</style>