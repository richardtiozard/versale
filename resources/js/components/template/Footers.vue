<template>
  <div class="warpper">
    <div class="contentwarpper">
      <div class="colbox mx-5">
        <p>FAQ</p>
        <p>Shipping & Return</p>
        <p>Terms & Policies</p>
        <p>Seller Centre</p>
      </div>
      <div class="colbox mx-5">
        <a href="/feedbacks/create"><p class="text-1">Customer Service</p></a>
        <p>Tel 016-7219845</p>
        <p>Email support@versale.com</p>
        <p><i class="fab fa-facebook-f mr-3"></i> <i class="fab fa-instagram mx-3"></i> <i class="fab fa-linkedin-in mx-3"></i></p>
      </div>
      <div class="colbox mx-5">
        <p>Subscribe for our Newsletter</p>
        <div class="newsletterform">
          <form action="" method="POST">
            <input v-model="newsletter.email" type="email" name="email" id='newsletter-footer' placeholder='Enter your email*'>
            <button @click="subscribe()" type="button" id='signup-newsletter-footer' class='button ml-2'>Subscribe</button>
            <p class="my-1" :class="{ success: isSuccess, error: isError }"> {{ text }} </p>
          </form>
        </div>
        <p class="my-4"><img :src="'/img/project/cards.png'" alt=""></p>
      </div>
    </div>
    <hr>
    <div class="copyright">
        <p>
          &copy; 2021 versale. All Rights Reserved
          <br/>
          Designed from stratch by Richard Oswald Tiozard
        </p>
    </div>
  </div>
</template>

<script>
export default {
  data: function(){
    return {
      newsletter:{
        email:""
      },
      text: "",
      isSuccess : false,
      isError : false
    }
  },
  methods: {
    subscribe(){
      if( this.newsletter.email == '' ){
        return;
      }
      axios.post('api/newsletter/store',{
        newsletter : this.newsletter
      })
      .then ( response => {
        if ( response.status == 201 ){
          this.newsletter.email = "";
          this.text = "You have successfully subscribed to our newsletter!"
          this.isSuccess = true;
          this.isError = false;
        }
      })
      .catch (error => {
        console.log (error);
        
        if ( error.response.status == 422 ){
          this.text = "Please enter a valid email address!"
        }
        else if ( error.response.status == 500 ){
          this.text = "You have already subscribed to our newsletter!"
        }
        this.newsletter.email = "";
        this.isSuccess = false;
        this.isError = true;
      })
    }
  }
}
</script>

<style scoped>
    .warpper{
        text-align: center;
        background-color: #134153;
        color: #FCFAF1;
        padding-bottom: 10px;
    }
    .contentwarpper{
      display: flex;
      justify-content: center;
    }
    .colbox{
      text-align: left;
    }

    #newsletter-footer{
      background-color: transparent;
      color: #FCFAF1;
      border: 2px solid #FCFAF1;
      padding: 3px;
      border-radius: 0;
      width: 250px;
    }
    #newsletter-footer::placeholder{
      color: #FCFAF1;
    }
    #signup-newsletter-footer{
      color: #FCFAF1;
      border: 0;
      padding: 6px 20px;
      background-color: rgba(144, 46, 46, 1);

      box-shadow: inset 0 0 20px rgba(46, 130, 139, 0);
      outline-color: rgba(190, 218, 250, .5);
      outline-offset: 0px;
      text-shadow: none;
      transition: all 1250ms cubic-bezier(0.19, 1, 0.22, 1);
    }
    #signup-newsletter-footer:hover {
      box-shadow: inset 0 0 20px rgba(46, 130, 139, .5), 0 0 20px rgba(46, 130, 139, .2);
      outline: 1px solid;
      outline-color: rgba(190, 218, 250, 0);
      outline-offset: 15px;
      text-shadow: 1px 1px 2px #2E828B; 
    }
    p.success{
      color: #1fd357;
    }
    p.error{
      color: #e40010;
    }
    .copyright{
      color: #999999;
    }
</style>