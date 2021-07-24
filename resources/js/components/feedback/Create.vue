<template>
    <div class="componentwarpper">
        <div class="warpper min-vh-100">
            <div class="content-warpper text-center">
                <h1 class="text-4 font-weight-600">Versale Customer Service</h1>
                <h6 class="mt-3">Have a question/problem? Please write here, we will reply back soonest.</h6>

                <div class="inputwarp mx-auto mt-5 bg-1 pt-4 pb-5 px-5 custom-box-shadow">
                    <div v-if="isSuccess" class="successmsg p-3 mt-4"><i class="fas fa-check text-9 mr-2"></i> {{ successtext }}.</div>
                    <div v-if="isError" class="errormsg p-3 mt-4"><i class="fas fa-times text-8 mr-2"></i> {{ errortext }}</div>
                    <div v-if="isEmpty" class="errormsg p-3 mt-4"><i class="fas fa-exclamation text-8 mr-2"></i> Please enter all the required fields.</div>

                    <span class="d-block mt-4 text-7 text-left">Title<span class="text-8">*</span></span> 
                    <input v-model="title" type="title" name="title" id='title' class="feedback-input" placeholder='Enter the title*' required autofocus>                    
                    
                    <span class="d-block mt-4 text-7 text-left">Message<span class="text-8">*</span></span> 
                    <textarea v-model="message" type="text" name="message" rows="5" id='message' class="feedback-input" style="resize: none" placeholder="Enter your message*" required></textarea>

                    <button @click="submitFeedback" type="button" class="d-inline-block register-button w-50 p-2 border-0 mt-4">
                        Submit
                    </button><button @click="clearFeedback" type="button" class="d-inline-block w-50 p-2 border-0 mt-4 bg-transparent text-8">
                        Clear
                    </button>                  
                </div>

            </div>

        </div>

        <Footers/>
    </div>
    
</template>

<script>
import Footers from '../template/Footers.vue'

export default {
    props: ['data'],
    components:{
        Footers,
    },
    data(){
        return{
            title: '',
            message: '',

            isSuccess: false,
            isError: false,
            errortext: "",
            successtext: "",
            isEmpty: false,
        }
    },
    methods:{

        submitFeedback(){
            if (this.title == '' || this.message == ''){
                this.isSuccess = false;
                this.isError = false;
                this.isEmpty = true;
            }
            else{
                axios.post('/feedbacks', {
                    title: this.title,
                    message: this.message,
                })
                .then( response => {
                    this.successtext = 'Your feedback has been successfully submitted.';
                    this.isSuccess = true;
                    this.isError = false;
                    this.isEmpty = false;
                    this.clearFeedback();
                })
                .catch( err => {
                    console.log(err.response.data)
                    this.errortext = 'Unable to submit feedback. Please try again later.';
                    this.isSuccess = false;
                    this.isError = true;
                    this.isEmpty = false;
                })
            }
        },
        clearFeedback(){
            this.title = '';
            this.message = '';
        }
    },
}

</script>

<style scoped>
    .content-warpper{
        width: 75%;
        margin: 0 auto;
    }

    .feedback-input{
        background-color: transparent;
        color: #333333;
        border: 2px solid #999999;
        padding: 5px;
        border-radius: 0;
        width: 100%;
    }
    .feedback-input:focus{
        background-color: transparent;
        color: #333333;
        border: 2px solid #333333;
        padding: 5px;
        border-radius: 0;
        width: 100%;
    }
    .feedback-input::placeholder{
        color: #999999;
    }
    .inputwarp{
        width: 45%;
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