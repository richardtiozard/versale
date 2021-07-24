<template>
    <div @click.self="closeRating" class="modalwarpper">
        <div class="modal-box p-5 text-center">
            <h4 class="text-center">Please Leave a Review</h4>
            <img src="/img/illustrator/rating.png" class="rating-img mt-4" alt="">
            <div class="mt-3">
                <div v-if="rating == 5" class="star">
                    <i @click="rating = 1" class="fas fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 2" class="fas fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 3" class="fas fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 4" class="fas fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 5" class="fas fa-star text-rating cursor-pointer"></i>
                </div>
                <div v-if="rating == 4" class="star">
                    <i @click="rating = 1" class="fas fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 2" class="fas fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 3" class="fas fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 4" class="fas fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 5" class="far fa-star text-rating cursor-pointer"></i>
                </div>
                <div v-if="rating == 3" class="star">
                    <i @click="rating = 1" class="fas fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 2" class="fas fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 3" class="fas fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 4" class="far fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 5" class="far fa-star text-rating cursor-pointer"></i>
                </div>
                <div v-if="rating == 2" class="star">
                    <i @click="rating = 1" class="fas fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 2" class="fas fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 3" class="far fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 4" class="far fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 5" class="far fa-star text-rating cursor-pointer"></i>
                </div>
                <div v-if="rating == 1" class="star">
                    <i @click="rating = 1" class="fas fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 2" class="far fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 3" class="far fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 4" class="far fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 5" class="far fa-star text-rating cursor-pointer"></i>
                </div>
                <div v-if="rating == 0" class="star">
                    <i @click="rating = 1" class="far fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 2" class="far fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 3" class="far fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 4" class="far fa-star text-rating cursor-pointer"></i>
                    <i @click="rating = 5" class="far fa-star text-rating cursor-pointer"></i>
                </div>
            </div>
            
            <textarea v-model="message" type="text" rows="4" class="form-input mt-3" style="resize: none" placeholder="Enter message"></textarea>

            <div @click="confirmed" class="confirmbutton mx-auto mt-3">Confirm</div>

        </div>
    </div>
</template>

<script>
export default {
    props:[

    ],
    data(){
        return{
            rating: 0,
            message: '',
        }
    },
    methods:{
        confirmed(){
            if(this.rating == 0){
                return
            }
            else{
                if(this.message == ''){
                    this.message = '-';
                }
                this.$emit('confirmed', this.rating, this.message);
            }
            
        },
        closeRating(){
            this.$emit('closeRating');
        }
    }
}
</script>

<style scoped>
.modalwarpper{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.6);

    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 15;
}
.rating-img{
    width: 150px;

}
.star{
    font-size: 48px;
}
.modal-box{
    width: 30%;
    background-color: white;
    border-radius: 15px;
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
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

.confirmbutton {
    cursor: pointer;
    text-align: center;
    line-height: 45px;
    width: 100%; 
    color: #FCFAF1;
    background-color: rgba(19, 65, 83, 1);
    max-width: 250px;
    box-shadow: inset 0 0 20px rgba(190, 218, 250, 0);
    outline-color: rgba(19, 65, 83, .5);
    outline-offset: 0px;
    text-shadow: none;
    transition: all 1250ms cubic-bezier(0.19, 1, 0.22, 1);
}
.confirmbutton:hover {
    box-shadow: inset 0 0 20px rgba(190, 218, 250, .5), 0 0 20px rgba(190, 218, 250, .2);
    outline: 1px solid;
    outline-color: rgba(190, 218, 250, 0);
    outline-offset: 15px;
    text-shadow: 1px 1px 2px #2E828B; 
}

</style>