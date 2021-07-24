<template>
    <div class="modalwarpper">
        <div class="modal-box p-5 text-center">
            <h4 class="text-center text-4">Horray, you have just completed an order!</h4>
            <div class="position-relative">
                <img src="/img/illustrator/dancing.png" alt="versale payment success" id="dancing-img" class="w-75 mt-5 pointer-events-none">
                <img src="/img/illustrator/partypop.png" alt="versale payment success" id="partypop-img" class="w-75 pointer-events-none">
            </div>
            <a href="/orders"><div class="confirmbutton mt-4 mx-auto">View My Orders</div></a>
        </div>
    </div>
</template>

<script>
export default {
    props:[

    ],
    methods:{

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
    z-index: 10;
}
.modal-box{
    position: relative;
    width: 40%;
    background-color: white;
    border-radius: 15px;
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
}

#dancing-img{
    position: relative;
    z-index: 5;
}
#partypop-img{
    position: absolute;
    top: 0;
    left: 12.5%;
    opacity: 0.3;
}

.confirmbutton {
    cursor: pointer;
    text-align: center;
    line-height: 45px;
    max-width: 200px;
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
</style>