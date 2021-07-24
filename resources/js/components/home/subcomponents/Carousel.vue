<template>
    <div class="position-relative mt-5">
        <div id="carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item slideitem active" :style="bgimg1"></div>
                <div class="carousel-item slideitem" :style="bgimg2"></div>
                <div class="carousel-item slideitem" :style="bgimg3"></div>
            </div>
        </div>
        <div class="bgcover">
            <div class="innerbgcover">
                <h1>Any Products, We Find For You</h1>
                <h5>Get Special Offers From Qualified Sellers!</h5>
                <a href="/requests/create" class="shopbutton text-1">Shop Now</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                bgimg1: {
                    background: 'url(../img/carousel/slide1.jpg) no-repeat center center fixed',
                    backgroundSize: 'cover',
                },
                bgimg2: {
                    background: 'url(../img/carousel/slide2.jpg) no-repeat center center fixed',
                    backgroundSize: 'cover'
                },
                bgimg3: {
                    background: 'url(../img/carousel/slide3.jpg) no-repeat center center fixed',
                    backgroundSize: 'cover'
                }
            }
        },
        methods: {
            
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style scoped>

.slideitem{
    width: 100%;
    height: calc(100vh - 70px);
}
.bgcover{
    position: absolute;
    top: 0;
    height: 100%;
    width: 100%;
    background-color: rgba(51, 51, 51, 0.4);

    display: flex;
    justify-content: center;
    align-items: center;
}
.innerbgcover{
    text-align: center;
    color: #FCFAF1;

    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.innerbgcover h1{
    font-size: 48px;
    font-weight: 600;
    line-height:1.5em;
}
.innerbgcover h5{
    font-family: 'Roboto', sans-serif;
    font-weight: 400;
    line-height:1.5em;
}

.shopbutton {
    cursor: pointer;
    line-height: 45px;
    margin-top: 15px;
    max-width: 160px;
    width: 100%; 
    background-color: rgba(19, 65, 83, 1);

    box-shadow: inset 0 0 20px rgba(46, 130, 139, 0);
    outline-color: rgba(190, 218, 250, .5);
    outline-offset: 0px;
    text-shadow: none;
    transition: all 1250ms cubic-bezier(0.19, 1, 0.22, 1);
}

.shopbutton:hover {
  box-shadow: inset 0 0 20px rgba(46, 130, 139, .5), 0 0 20px rgba(46, 130, 139, .2);
  outline: 1px solid;
  outline-color: rgba(190, 218, 250, 0);
  outline-offset: 15px;
  text-shadow: 1px 1px 2px #2E828B; 
  color: #FCFAF1;
}
</style>
