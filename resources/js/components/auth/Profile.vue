<template>
    <div class="componentwarpper">
        <div class="warpper">
            <div class="content-warpper bg-1 custom-box-shadow p-5">
                <div class="w-100 mb-5">
                    <h4 class="d-inline-block w-50 font-weight-600">My Profile</h4>
                    <div @click="saveProfile" class="d-inline-block w-50 save-button">Save</div>
                </div>

                <div v-if="isSuccess" class="successmsg p-3 my-4"><i class="fas fa-check text-9 mr-2"></i> Profile is successfully updated.</div>
                <div v-if="isError" class="errormsg p-3 my-4"><i class="fas fa-times text-8 mr-2"></i> {{ errortext }}</div>
                <div v-if="isEmpty" class="errormsg p-3 my-4"><i class="fas fa-exclamation text-8 mr-2"></i> Please enter all the required fields.</div>
                
                <form class="d-flex align-items-end justify-content-center w-100">
                    
                    <div class="w-50 mr-5">
                        <div id="profileimgwarpper" class="text-center">
                            <img :src="previewimage" alt="Versale Profile" class="cursor-pointer" @click="selectImage">
                            <p class="mt-2 cursor-pointer" @click="selectImage">Upload Image</p> 
                            <input ref="fileInput" type="file" class="d-none" @change="onFileChange">
                        </div>

                        <label for="fullname" class="d-block mt-4 text-7">Fullname<span class="text-8">*</span></label> 
                        <input v-model="userProfile.fullname" type="fullname" name="fullname" id='fullname' class="input" placeholder='Enter your fullname*' required>
                        
                        <label for="phonenumber" class="d-block mt-4 text-7">Phone Number<span class="text-8">*</span></label> 
                        <input v-model="userProfile.phonenumber" type="tel" name="phonenumber" id='phonenumber' class="input" placeholder='Enter your phone number* (e.g. 01675498)' required>
                    </div>

                    <div class="w-50 ml-5 mt-5">
                        <label for="country" class="d-block text-7">Country<span class="text-8">*</span></label> 
                        <input v-model="userProfile.country" type="country" name="country" id='country' class="input" placeholder='Enter your country*' required>

                        <label for="city" class="d-block mt-4 text-7">City<span class="text-8">*</span></label> 
                        <input v-model="userProfile.city" type="city" name="city" id='city' class="input" placeholder='Enter your city*' required>
                        
                        <label for="address" class="d-block mt-4 text-7">Address<span class="text-8">*</span></label> 
                        <input v-model="userProfile.address" type="address" name="address" id='address' class="input" placeholder='Enter your address*' required>
                        
                        <label for="zipcode" class="d-block mt-4 text-7">ZIP Code<span class="text-8">*</span></label> 
                        <input v-model="userProfile.zipcode" type="zipcode" name="zipcode" id='zipcode' class="input" placeholder='Enter your ZIP code*' required>
                    
                    </div>
                    

                </form>
            </div>
        </div>

        <Footers/>
    </div>
</template>

<script>
import Footers from '../template/Footers.vue'

export default {
    props: ['loggedUser', 'userProfile'],
    components:{
        Footers,
    },
    data(){
        return{
            previewimage: this.userProfile.image,

            isSuccess: false,
            isError: false,
            errortext: "",
            isEmpty: false,
        }
    },
    methods:{
        selectImage () {
            this.$refs.fileInput.click()
        },

        onFileChange(e) {
            this.userProfile.image = e.target.files[0];
            this.previewimage = URL.createObjectURL(this.userProfile.image);
            this.uploadImage();
        },

        uploadImage(){
            let formData = new FormData();
            formData.append('image', this.userProfile.image);
            axios.post( '/'+ this.loggedUser.role + '/profile/uploadimage',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            )
            .then( response => {
                console.log("Image is Uploaded");
            })
            .catch ( error => {
                console.log(error.response.data);
                this.isSuccess = false;
                this.isError = true;
                this.isEmpty = false;
                this.errortext = Object.values(error.response.data.errors).flat().join();
            })
        },

        saveProfile(){
            if( this.userProfile.fullname == "" || this.userProfile.phonenumber == "" || this.userProfile.country == "" || this.userProfile.city == "" || this.userProfile.address == "" || this.userProfile.zipcode == ""){
                this.isSuccess = false;
                this.isError = false;
                this.isEmpty = true;
            }
            else{
                axios.put( '/'+ this.loggedUser.role + '/profile/update',{
                    'userprofile': this.userProfile
                })
                .then( response => {
                    this.isSuccess = true;
                    this.isError = false;
                    this.isEmpty = false;
                    console.log("Profile is successfully updated.");
                    window.history.back();
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
        console.log(this.userProfile);
    }
}
</script>

<style scoped>
    .content-warpper{
        width: 50%;
        margin: 0 auto;
    }

    .input{
        background-color: transparent;
        color: #333333;
        border: 2px solid #999999;
        padding: 5px;
        border-radius: 0;
        width: 100%;
    }
    .input:focus{
        color: #333333;
        border: 2px solid #333333;
    }
    .input:focus {
        color: #333333;
        border: 2px solid #333333;
    }

    .input::placeholder{
        color: #999999;
    }

    #profileimgwarpper img{
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 0;
        border-radius: 50%;
        box-shadow: 0px 0px 19px -5px rgba(0,0,0,1);
        -webkit-box-shadow: 0px 0px 19px -5px rgba(0,0,0,1);
        -moz-box-shadow: 0px 0px 19px -5px rgba(0,0,0,1);
    }

    .save-button {
        float: right;
        cursor: pointer;
        text-align: center;
        line-height: 45px;
        max-width: 160px;
        width: 100%; 
        color: #FCFAF1;
        background-color: rgba(19, 65, 83, 1);

        box-shadow: inset 0 0 20px rgba(190, 218, 250, 0);
        outline-color: rgba(19, 65, 83, .5);
        outline-offset: 0px;
        text-shadow: none;
        transition: all 1250ms cubic-bezier(0.19, 1, 0.22, 1);
    }
    .save-button:hover {
        box-shadow: inset 0 0 20px rgba(190, 218, 250, .5), 0 0 20px rgba(190, 218, 250, .2);
        outline: 1px solid;
        outline-color: rgba(190, 218, 250, 0);
        outline-offset: 15px;
        text-shadow: 1px 1px 2px #2E828B; 
    }
</style>