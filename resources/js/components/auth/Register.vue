<template>
    <div class="componentwarpper">
        <div class="contentwarpper" :style="bgimg"></div>
        <div class="bgcover">
            <div v-if="page == 1" class="section-box bg-1 p-5 text-center position-relative">
                <div class=""><h4>Select Your Role</h4></div>
                <div class="pagenum position-absolute text-7"><h6>({{page}}/3)</h6></div>
                
                <div @click="selectRole('seller')" class="rolebox d-inline-block w-50 py-4 mt-3 text-center">
                    <img class="my-3" :src="'../img/illustrator/seller.png'" alt="Versale">
                    <h6>I Want To Sell Products</h6>

                </div><div @click="selectRole('buyer')" class="rolebox d-inline-block w-50 py-4 mt-3 text-center">
                    <img class="my-3" :src="'../img/illustrator/buyer.png'" alt="Versale">
                    <h6>I Want To Buy Products</h6>
                </div>

                <hr>
                <div class="text-center text-7">Already Have An Account? <b><a @click="login" class="text-5">Log In</a></b></div>
            </div>

            <div v-if="page == 2" class="section-box bg-1 p-5 text-center position-relative">
                <div @click="stepBack" class="backbtn position-absolute text-7"><h6> <i class="fas fa-angle-left"></i> Back</h6></div>
                <div class=""><h4>Registration</h4></div>
                <div class="pagenum position-absolute text-7"><h6>({{page}}/3)</h6></div>
                
                <div class="d-flex justify-content-center align-items-center">
                    <div v-if="user.role == 'seller'" class="d-inline-block text-center w-50">
                        <img class="my-3" :src="'../img/illustrator/seller.png'" alt="Versale">
                        <h6>I Want To Sell Products</h6>
                    </div>
                    <div v-if="user.role == 'buyer'" class="d-inline-block text-center w-50">
                        <img class="my-3" :src="'../img/illustrator/buyer.png'" alt="Versale">
                        <h6>I Want To Buy Products</h6>
                    </div><div class="d-inline-block py-4 mt-3 text-left w-50">
                        <form>
                            <div v-if="isSuccess" class="successmsg p-3 mt-4"><i class="fas fa-check text-9 mr-2"></i> Email Available.</div>
                            <div v-if="isError" class="errormsg p-3 mt-4"><i class="fas fa-times text-8 mr-2"></i> {{ errortext }}</div>
                            <div v-if="isEmpty" class="errormsg p-3 mt-4"><i class="fas fa-exclamation text-8 mr-2"></i> Please enter all the required fields.</div>

                            <label for="email" class="d-block mt-4 text-7">Email Address<span class="text-8">*</span></label> 
                            <input v-model="user.email" type="email" name="email" id='email' class="register-input" placeholder='Enter your email*' required autofocus>
                            
                            <label for="password" class="d-block mt-4 text-7">Password<span class="text-8">*</span> (Min. 8 Characters)</label> 
                            <input v-model="user.password" type="password" name="password" id='password' class="register-input" placeholder='Enter your password*' required>

                            <label for="confirmpassword" class="d-block mt-4 text-7">Confirm Password<span class="text-8">*</span> (Min. 8 Characters)</label> 
                            <input v-model="user.confirmpassword" type="password" name="confirmpassword" id='confirmpassword' class="register-input" placeholder='Confirm your password*' required>
                            
                            <button @click="checkUser()" type="button" class="register-button w-100 p-2 border-0 mt-4">Next</button>
                        </form>
                    </div>
                </div>
                
                <hr>
                <div class="text-center text-7">Already Have An Account? <b><a @click="login" class="text-5">Log In</a></b></div>
            </div>

            <div v-if="page == 3" class="section-box bg-1 p-5 text-center position-relative">
                <div @click="stepBack" class="backbtn position-absolute text-7"><h6> <i class="fas fa-angle-left"></i> Back</h6></div>
                <div class=""><h4>Final Touch, Complete Your Profile Information</h4></div>
                <div class="pagenum position-absolute text-7"><h6>({{page}}/3)</h6></div>
                
                <div class="text-left mt-3">

                    <div v-if="isSuccess" class="successmsg p-3 my-4"><i class="fas fa-check text-9 mr-2"></i> Successfully registered. </div>
                    <div v-if="isError" class="errormsg p-3 my-4"><i class="fas fa-times text-8 mr-2"></i> {{ errortext }}</div>
                    <div v-if="isEmpty" class="errormsg p-3 my-4"><i class="fas fa-exclamation text-8 mr-2"></i> Please enter all the required fields. </div>        

                    <form class="d-flex align-items-start justify-content-center">
                        <div class="w-50 mx-3 h-100">
                            
                            <label for="username" class="d-block mt-4 text-7">Username<span class="text-8">*</span></label> 
                            <input v-model="user.username" type="username" name="username" id='username' class="register-input" placeholder='Enter your username*' required autofocus>

                            <label for="fullname" class="d-block mt-4 text-7">Fullname<span class="text-8">*</span></label> 
                            <input v-model="user.fullname" type="fullname" name="fullname" id='fullname' class="register-input" placeholder='Enter your fullname*' required>
                            
                            <label for="phonenumber" class="d-block mt-4 text-7">Phone Number<span class="text-8">*</span></label> 
                            <input v-model="user.phonenumber" type="tel" name="phonenumber" id='phonenumber' class="register-input" placeholder='Enter your phone number* (e.g. 01675498)' required>

                            <span class="d-block mt-4 text-7">Gender<span class="text-8">*</span></span>
                            <div class="mt-1">
                                <input v-model="user.gender" type="radio" id="male" name="gender" value="male">
                                <label for="male" class="text-7 mr-5">Male</label>
                                <input v-model="user.gender" type="radio" id="female" name="gender" value="female">
                                <label for="female" class="text-7 mr-5">Female</label>
                                <input v-model="user.gender" type="radio" id="other" name="gender" value="other">
                                <label for="other" class="text-7 mr-5">Other</label>
                            </div>  

                            <button @click="uploadProfile" type="button" class="d-inline-block register-button w-50 p-2 border-0 mt-5">
                                Register
                            </button><button @click="clearProfile" type="button" class="d-inline-block w-50 p-2 border-0 mt-5 bg-transparent text-8">
                                Clear
                            </button>

                        </div>
                        <div class="w-50 mx-3 h-100">   

                            <label for="country" class="d-block mt-4 text-7">Country<span class="text-8">*</span></label> 
                            <input v-model="user.country" type="country" name="country" id='country' class="register-input" placeholder='Enter your country*' required>

                            <label for="city" class="d-block mt-4 text-7">City<span class="text-8">*</span></label> 
                            <input v-model="user.city" type="city" name="city" id='city' class="register-input" placeholder='Enter your city*' required>
                            
                            <label for="address" class="d-block mt-4 text-7">Address<span class="text-8">*</span></label> 
                            <input v-model="user.address" type="address" name="address" id='address' class="register-input" placeholder='Enter your address*' required>
                            
                            <label for="zipcode" class="d-block mt-4 text-7">ZIP Code<span class="text-8">*</span></label> 
                            <input v-model="user.zipcode" type="zipcode" name="zipcode" id='zipcode' class="register-input" placeholder='Enter your ZIP code*' required>
                        
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <Footers/>
    </div>
</template>

<script>
import Footers from '../template/Footers.vue'
export default {
    components:{
        Footers
    },
    props:
        ['loginRoute', 'registerRoute'],
    data(){
        return{
            bgimg: {
                background: 'url(../img/project/login-bg.jpg) no-repeat center center fixed',
                backgroundSize: 'cover',
            },
            page: 1,
            user:{
                role: "",
                email: "",
                password: "",
                confirmpassword: "",

                username:"",
                fullname:"",
                phonenumber:"",
                gender:"",
                country:"",
                city:"",
                address:"",
                zipcode:"",
                // image:"defaultprofile.png",
                // previewimage:"img/illustrator/defaultprofile.png",
            },

            isSuccess: false,
            isError: false,
            errortext: "",
            isEmpty: false,
        }
    },
    methods:{
        selectRole(selectedRole){
            this.user.role = selectedRole;
            this.page = this.page + 1;
        },
        stepBack(){
            this.page = this.page - 1;
            this.isSuccess = false;
            this.isError = false;
            this.isEmpty = false;
        },
        stepForward(){
            this.page = this.page + 1
        },

        login(){
            axios.get(this.loginRoute)
            .then( response => {
                window.location.href = this.loginRoute;
                console.log(response);
            })
            .catch( error => {
                console.log(error);
            })
        },

        checkUser(){
            if (this.user.email == "" || this.user.password == "" || this.user.confirmpassword == ""){
                this.isSuccess = false;
                this.isError = false;
                this.isEmpty = true;
            }
            else if (this.user.password != this.user.confirmpassword){
                this.errortext = "Confirm password do not match, please try again."
                this.isSuccess = false;
                this.isError = true;
                this.isEmpty = false;
            }
            else{
                axios.post('/register/check', {
                    user: this.user
                })
                .then( response => {
                    console.log(response.data);
                    this.isSuccess = false;
                    this.isError = false;
                    this.isEmpty = false;
                    this.page = this.page + 1;
                })
                .catch( error => {
                    if ( error.response.status == 422 ){
                        this.errortext = Object.values(error.response.data.errors).flat().join();
                    }
                    else if ( error.response.status == 500 ){
                        this.errortext = "Unable to register, please try again later."
                    }
                    this.isSuccess = false;
                    this.isError = true;
                    this.isEmpty = false;
                    this.user.password = "";
                    this.user.confirmpassword = "";
                    console.log(error.response.data);
                })
            }
        },

        uploadProfile(){
            if (this.user.username == "" || this.user.fullname == "" || this.user.phonenumber == "" || this.user.gender == "" || this.user.country == "" || this.user.city == "" || this.user.address == "" || this.user.zipcode == ""){
                this.isSuccess = false;
                this.isError = false;
                this.isEmpty = true;
            }
            else if (this.user.password != this.user.confirmpassword){
                this.errortext = "Confirm password do not match, please try again."
                this.isSuccess = false;
                this.isError = true;
                this.isEmpty = false;
            }
            else{
                axios.post(this.registerRoute, {
                    email: this.user.email,
                    password: this.user.password,
                    role: this.user.role,
                    username: this.user.username,
                    fullname: this.user.fullname,
                    phonenumber: this.user.phonenumber,
                    gender: this.user.gender,
                    country: this.user.country,
                    city: this.user.city,
                    address: this.user.address,
                    zipcode: this.user.zipcode
                })
                .then( response => {
                    this.isSuccess = true;
                    this.isError = false;
                    this.isEmpty = false;
                    window.location.href = '/home';
                })
                .catch( error => {
                    if ( error.response.status == 422 ){
                        this.errortext = Object.values(error.response.data.errors).flat().join();
                    }
                    else if ( error.response.status == 500 ){
                        this.errortext = "Unable to register, please try again later."
                    }
                    this.isSuccess = false;
                    this.isError = true;
                    this.isEmpty = false;
                    console.log(error.response.data);
                })
            }
        },

        register(){
            try{
                this.uploadProfile();
                this.uploadImage();
            }
            catch (ex){
                console.log('error');
            }
            
            
        },

        clearProfile(){
            this.user.username = "";
            this.user.fullname = "";
            this.user.phonenumber = "";
            this.user.country = "";
            this.user.city = "";
            this.user.address = "";
            this.user.zipcode = "";
        }
    }
}
</script>

<style scoped>
.contentwarpper{
    width: 100%;
    height: calc(100vh - 70px);
}
.bgcover{
    position: absolute;
    top: 0;
    height: calc(100vh - 70px);
    width: 100%;
    background-color: rgba(0, 0, 0, 0.8);

    display: flex;
    justify-content: center;
    align-items: center;
}
img.logo{
    width: 200px;
}

.section-box{
    width: 60%;
    border-radius: 5px;
    background-color: white;
}

.backbtn{
    top: 50px;
    left: 50px;
    cursor: pointer;
}
.backbtn:hover i, .backbtn:hover h6{
    color: #134153;
}
.pagenum{
    top:50px;
    right: 50px;
}

a.text-5:hover{
    color: #902E2E;
}

/* Page 1 */
.rolebox{
    cursor: pointer;
    transition: all 0.3s ease-in-out;
}
.rolebox:hover{
    background-color: rgba(19, 65, 83, 1);
}
.rolebox h6{
    transition: all 0.3s ease-in-out;
}
.rolebox:hover h6{
    color: #FCFAF1;
}


/* Page 2 */
.register-input{
      background-color: transparent;
      color: #333333;
      border: 2px solid #999999;
      padding: 5px;
      border-radius: 0;
      width: 100%;
}
.register-input:focus{
      color: #333333;
      border: 2px solid #333333;
}
.register-input:focus {
      color: #333333;
      border: 2px solid #333333;
}

.register-input::placeholder{
    color: #999999;
}
.register-button {
    background-color: rgba(19, 65, 83, 1);
    color: #FCFAF1;
    box-shadow: inset 0 0 20px rgba(190, 218, 250, 0);
    outline-color: rgba(19, 65, 83, .5);
    outline-offset: 0px;
    text-shadow: none;
    transition: all 1250ms cubic-bezier(0.19, 1, 0.22, 1);
}
.register-button:hover {
  box-shadow: inset 0 0 20px rgba(190, 218, 250, .5), 0 0 20px rgba(46, 130, 139, .2);
  outline: 1px solid;
  outline-color: rgba(190, 218, 250, 0);
  outline-offset: 15px;
  text-shadow: 1px 1px 2px #2E828B; 
}


</style>