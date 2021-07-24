<template>
    <div class="componentwarpper">
        <div class="contentwarpper" :style="bgimg"></div>
        <div class="bgcover">
            <div class="sidebox-left mx-5 text-center">
                <img class="logo d-block mx-auto" :src="'../img/project/versaleicon.png'" alt="Versale">
                <h3 class="text-1 mt-5">The leading online shopping platform with reversed marketplace</h3>
            </div>
            <div class="sidebox-right mx-5 p-5 position-relative">
                <h4>Log In</h4>
                <form class="mt-3">

                    <div v-if="isSuccess" class="successmsg p-3 mt-4"><i class="fas fa-check text-9 mr-2"></i> Login successfully.</div>
                    <div v-if="isError" class="errormsg p-3 mt-4"><i class="fas fa-times text-8 mr-2"></i> {{ errMessage }}</div>
                    <div v-if="isEmpty" class="errormsg p-3 mt-4"><i class="fas fa-exclamation text-8 mr-2"></i> Please enter all the required fields.</div>
                    
                    <span class="d-block mt-4 text-7">Email Address<span class="text-8">*</span></span> 
                    <input v-model="email" type="email" name="email" id='email' class="login-input" placeholder='Enter your email*' required autofocus>
                    
                    <span class="d-block mt-4 text-7">Password<span class="text-8">*</span></span> 
                    <input @keypress.enter="login" v-model="password" type="password" name="password" id='password' class="login-input" placeholder='Enter your password*' required>
                    
                    <button @click="login" type="button" class="login-button w-100 p-2 border-0 mt-4">Log In</button>
                    
                    <div class="d-inline-block mt-2 text-3" >
                        <input type="checkbox" v-model="isRemember" class="mt-1"><a class="text-3" @click="isRemember = !isRemember"> Remember Me</a>
                    </div>

                    <span class="d-inline-block mt-2 float-right"><a class="text-3" href="/password/reset">Forgot Password</a></span> 

                </form>
                <hr class="mt-5">
                <div class="text-center text-7">New To Versale? <b><a @click="register" class="text-5">Sign Up</a></b></div>
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
        ['loginRoute','registerRoute'],
    data(){
        return{
            bgimg: {
                    background: 'url(../img/project/login-bg.jpg) no-repeat center center fixed',
                    backgroundSize: 'cover',
            },
            email : "",
            password : "",
            isRemember: false,
            isSuccess: false,
            isError: false,
            isEmpty: false,
            errMessage: "",
        }
    },
    methods:{
        login(){
            if(email == ""|| this.password == ""){
                this.isSuccess = false,
                this.isError = false;
                this.isEmpty = true;
                return;
            }
            axios.post(this.loginRoute, {
                email: this.email,
                password: this.password,
                remember: this.isRemember
            })
            .then( response => {
                this.isSuccess = true,
                this.isError = false;
                this.isEmpty = false;
                this.email = "";
                this.password = "";
                window.location.href = '/home';
                console.log(response);
            })
            .catch( error => {
                this.errMessage = 'Incorrect email or password. Please try again.';
                this.isSuccess = false,
                this.isError = true;
                this.isEmpty = false;
                this.password = "";
                console.log(error);
            })
        },

        register(){
            axios.get(this.registerRoute)
            .then( response => {
                window.location.href = this.registerRoute;
                console.log(response);
            })
            .catch( error => {
                console.log(error);
            })
        }
    },
    mounted(){
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
.sidebox-left{
    width: 35%;
}
.sidebox-left h3{
    line-height: 1.5em;
}
.sidebox-right{
    width: 30%;
    border-radius: 5px;
    background-color: white;
}

.login-input{
      background-color: transparent;
      color: #333333;
      border: 2px solid #999999;
      padding: 5px;
      border-radius: 0;
      width: 100%;
}
.login-input:focus{
      background-color: transparent;
      color: #333333;
      border: 2px solid #333333;
      padding: 5px;
      border-radius: 0;
      width: 100%;
}
.login-input::placeholder{
    color: #999999;
}

.login-button {
    background-color: rgba(19, 65, 83, 1);
    color: #FCFAF1;
    box-shadow: inset 0 0 20px rgba(190, 218, 250, 0);
    outline-color: rgba(19, 65, 83, .5);
    outline-offset: 0px;
    text-shadow: none;
    transition: all 1250ms cubic-bezier(0.19, 1, 0.22, 1);
}

.login-button:hover {
  box-shadow: inset 0 0 20px rgba(190, 218, 250, .5), 0 0 20px rgba(46, 130, 139, .2);
  outline: 1px solid;
  outline-color: rgba(190, 218, 250, 0);
  outline-offset: 15px;
  text-shadow: 1px 1px 2px #2E828B; 
}

a.text-3:hover{
    color: #134153;
}
a.text-5:hover{
    color: #902E2E;
}
.forgotpass{
    right: 0;
}


</style>