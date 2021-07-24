<template>
    <div @click.self="closeModal" class="modalwarpper">
        <div class="modal-box p-5">
            <h4 class="text-center">{{title}}</h4>
            <div class="row mt-5">
                <div @click="confirmed" class="confirmbutton col-6">Yeah, I'm sure</div>
                <div @click="closeModal" class="deletebutton col-6">Cancel</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:[
        'title'
    ],
    methods:{
        confirmed(){
            this.$emit('confirmed');
        },
        closeModal(){
            this.$emit('closeConfirmModal');
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
}

.modal-box{
    width: 40%;
    background-color: white;
    border-radius: 15px;
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
}
.confirmbutton {
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
.confirmbutton:hover {
    box-shadow: inset 0 0 20px rgba(190, 218, 250, .5), 0 0 20px rgba(190, 218, 250, .2);
    outline: 1px solid;
    outline-color: rgba(190, 218, 250, 0);
    outline-offset: 15px;
    text-shadow: 1px 1px 2px #2E828B; 
}

.deletebutton {
    cursor: pointer;
    text-align: center;
    line-height: 45px;
    width: 100%; 
    color: #E40041;
}
</style>