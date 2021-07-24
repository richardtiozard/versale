<template>
    <div class="componentwarpper">
        <div class="warpper min-vh-100">
            <div class="content-warpper bg-1 custom-box-shadow px-5 pt-5 pb-4">
                <img src="/img/illustrator/divider-top.png" alt="" class="dividerimg">
                <h5 class="text-3"><i class="fas fa-map-marker-alt"></i> Delivery Address</h5>
                <div class="row mt-4">
                    <p class="col-11"><span class="font-weight-600">{{ this.data.buyer[0].fullname }} (+60) {{ this.data.buyer[0].phonenumber}}</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ this.data.buyer[0].address}}, {{ this.data.buyer[0].zipcode}}, {{ this.data.buyer[0].city}}, {{ this.data.buyer[0].country}}</span></p>
                    <a href="/buyer/profile"><p class="col-1 text-3 text-right font-weight-600 cursor-pointer">Change</p></a>
                </div>
            </div>

            <div class="content-warpper bg-1 custom-box-shadow px-5 pt-5 pb-4 mt-4">
                <div class="row">
                    <h5 class="col-7">Product Ordered</h5>
                    <p class="col-1 text-center text-7">Price</p>
                    <p class="col-1 text-center text-7">Quantity</p>
                    <p class="col-3 text-right text-7">Subtotal</p>
                </div>
                
                <div class="row mt-5 align-items-center">
                    <img :src="data.offer[0].product_image" alt="" class="productimg col-1">
                    <p class="col-3">{{ data.offer[0].product_name }}</p>
                    <p class="col-3 text-7">{{ data.offer[0].product_description }}</p>
                    <p class="col-1 text-center">RM{{ data.offer[0].product_price }}</p>
                    <p class="col-1 text-center">{{ data.offer[0].request_quantity }}</p>
                    <p class="col-3 text-right">RM{{ total_amount }}</p>
                    <hr class="col-12">
                    <div class="col-9"></div>
                    <p class="col-3">
                        <span class="text-7">Order Total ({{ data.offer[0].request_quantity }} item):</span> 
                        <span class="h5 text-3 float-right">RM{{ total_amount }}</span> 
                    </p>
                </div>
            </div>

            <div class="content-warpper bg-1 custom-box-shadow px-5 p-5 mt-4">
                <h5 class="d-inline">Billing Address</h5>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" v-model="default_address" id="default_address" name="default_address" class="d-inline cursor-pointer"> <label for="default_address" class="d-inline cursor-pointer"> Use default address</label>

                <div class="row mt-3 justify-content-between w-75 mx-auto">

                    <div v-if="isSuccess" class="successmsg col-12 p-3 mt-4"><i class="fas fa-check text-9 mr-2"></i> Successfully ordered the product. </div>
                    <div v-if="isError" class="errormsg col-12 p-3 mt-4"><i class="fas fa-times text-8 mr-2"></i> {{ errortext }}</div>
                    <div v-if="isEmpty" class="errormsg col-12 p-3 mt-4"><i class="fas fa-exclamation text-8 mr-2"></i> Please enter all the required fields. </div>   
                    
                    <div class="col-6 w-75">
                        <label for="fullname" class="d-block mt-4 text-7">Cardholder Name<span class="text-8">*</span></label> 
                        <input v-model="billing_address.cardholder_name" type="text" name="fullname" id='fullname' class="input w-100" placeholder='Enter your cardholder name*' required>
                        
                        <div class="row">
                            <div class="col-6">
                                <label for="country" class="d-block mt-4 text-7">Country<span class="text-8">*</span></label> 
                                <input v-model="billing_address.country" type="text" name="country" id='country' class="input w-100" placeholder='Enter your country*' required>
                            </div>
                            <div class="col-6">
                                <label for="city" class="d-block mt-4 text-7">City<span class="text-8">*</span></label> 
                                <input v-model="billing_address.city" type="text" name="city" id='city' class="input w-100" placeholder='Enter your city*' required>
                            </div>
                        </div>
                        
                        <label for="address" class="d-block mt-4 text-7">Address<span class="text-8">*</span></label> 
                        <input v-model="billing_address.address" type="text" name="address" id='address' class="input w-100" placeholder='Enter your address*' required>
                        
                        <label for="zipcode" class="d-block mt-4 text-7">ZIP Code<span class="text-8">*</span></label> 
                        <input v-model="billing_address.zipcode" type="number" maxlength="5" name="zipcode" id='zipcode' class="input w-100" placeholder='Enter your zip code*' required>
                    </div>
                    <div class="col-5 w-75">
                        <label for="cardnumber" class="d-block mt-4 text-7">Credit Card Number<span class="text-8">*</span></label> 
                        <input v-model="billing_address.credit_card_number" type="number" name="cardnumber" id='cardnumber' class="input w-100" placeholder='Enter your credit card number*' required>
                        
                        <div class="row">
                            <div class="col-6">
                                <label for="exp_month" class="d-block mt-4 text-7">Expire Date<span class="text-8">*</span></label> 
                                <div class="row">
                                    <div class="col-6 pr-0"><input v-model="billing_address.exp_month" type="text" name="exp_month" id='exp_month' class="input w-100" maxlength="2" pattern="[0-9]{2}" placeholder='mm' required></div>
                                    <div class="col-6 pr-0"><input v-model="billing_address.exp_year" type="text" name="exp_year" id='exp_year' class="input w-100" maxlength="2" pattern="[0-9]{2}" placeholder='yy' required></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="cvv" class="d-block mt-4 text-7">CVV<span class="text-8">*</span></label> 
                                <input v-model="billing_address.cvv" type="text" name="cvv" id='cvv' class="input w-100" maxlength="3" placeholder='Enter your CVV*' required>
                            </div>
                            <div class="col-12 mt-5">
                                <input type="checkbox" v-model="billing_address.checked" id="verify_acknowledge" name="verify_acknowledge" class="d-inline cursor-pointer"> <label for="verify_acknowledge" class="d-inline cursor-pointer"> I hereby acknowledge that my card information is saved securely on my Versale account.<span class="text-8">*</span></label>
                            </div>
                            <div class="col-12 mt-4">
                                <div @click="placeOrder" class="orderbutton">Place Order</div>
                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
        <payment-success v-if="isSuccess"></payment-success>
        <Footers/>
    </div>
    
</template>

<script>
import Footers from '../template/Footers.vue';
import PaymentSuccess from './subcomponents/PaymentSuccess.vue';

export default {
    props: ['data'],
    components:{
        Footers,
        PaymentSuccess,
    },
    data(){
        return{
            billing_address:{
                cardholder_name: '',
                country: '',
                city: '',
                address: '',
                zipcode: '',
                credit_card_number: '',
                exp_month: '',
                exp_year: '',
                cvv: '',
                
                checked: false
            },
            default_address: false,

            isSuccess: false,
            isError: false,
            isEmpty: false,
            errortext: "",
        }
    },
    methods:{
        
        toggleDefaultAddress(val){
            if ( val == true ){
                this.billing_address.cardholder_name = this.data.buyer[0].fullname;
                this.billing_address.country = this.data.buyer[0].country;
                this.billing_address.city = this.data.buyer[0].city;
                this.billing_address.address = this.data.buyer[0].address;
                this.billing_address.zipcode = this.data.buyer[0].zipcode;
            }
            else{
                this.billing_address.cardholder_name = '';
                this.billing_address.country = '';
                this.billing_address.city = '';
                this.billing_address.address = '';
                this.billing_address.zipcode = '';
            }
        },

        placeOrder(){
            if ( this.billing_address.cardholder_name == "" || this.billing_address.country == "" || this.billing_address.city == "" || this.billing_address.address == "" || this.billing_address.zipcode == "" || this.billing_address.credit_card_number == "" || this.billing_address.exp_month == "" || this.billing_address.exp_year == "" || this.billing_address.cvv == "" || this.billing_address.checked == false){
                this.isSuccess= false;
                this.isError= false;
                this.isEmpty= true;
            }
            else{
                axios.post('/payment',{
                    offer_id : this.data.offer[0].offer_id,
                    request_id : this.data.offer[0].request_id,
                    amount : this.total_amount
                })
                .then (response => {
                    this.isSuccess= true;
                    this.isError= false;
                    this.isEmpty= false;
                    this.billing_address.cardholder_name = '';
                    this.billing_address.country = '';
                    this.billing_address.city = '';
                    this.billing_address.address = '';
                    this.billing_address.zipcode = '';
                    this.billing_address.credit_card_number = '';
                    this.billing_address.exp_month = '';
                    this.billing_address.exp_year = '';
                    this.billing_address.cvv = '';
                    document.body.style.overflow = 'hidden';
                })
                .catch (err => {
                    this.isSuccess= false;
                    this.isError= true;
                    this.isEmpty= false;
                    this.errortext = "Unable to place order, please try again later";
                    console.log(err.response.data);
                });
            }
        }
        
    },
    computed:{
        total_amount(){
            return this.data.offer[0].product_price * this.data.offer[0].request_quantity;
        }
    },
    watch:{
        'default_address': function(newVal, oldVal){
            this.toggleDefaultAddress(newVal);
        },
    },
    mounted(){
        console.log(this.data);
        if (localStorage.getItem('reloaded')) {
            // The page was just reloaded. Clear the value from local storage
            // so that it will reload the next time this page is visited.
            localStorage.removeItem('reloaded');
        } else {
            // Set a flag so that we know not to reload the page twice.
            localStorage.setItem('reloaded', '1');
            location.reload();
        }
    }
}

</script>

<style scoped>
    .content-warpper{
        position: relative;
        width: 75%;
        margin: 0 auto;
    }
    .dividerimg{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 40px;
        pointer-events: none;
    }
    .productimg{
        width: 100px;
        height: 100px;
        object-fit: contain;
    }

    .input{
        background-color: transparent;
        color: #333333;
        border: 2px solid #999999;
        padding: 5px;
        border-radius: 0;
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

    .orderbutton {
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
    .orderbutton:hover {
        box-shadow: inset 0 0 20px rgba(190, 218, 250, .5), 0 0 20px rgba(190, 218, 250, .2);
        outline: 1px solid;
        outline-color: rgba(190, 218, 250, 0);
        outline-offset: 15px;
        text-shadow: 1px 1px 2px #2E828B; 
    }

</style>