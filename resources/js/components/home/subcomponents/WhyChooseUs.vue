<template>
      <div class="warpper d-flex flex-column justify-content-center">
        <h1 class="sectiontitle">Why Choose Us ?</h1>
        <div class="contentwarpper">
            <div class="mx-5 w-25">
                <img class="w-100" :src="'../img/project/versaleicon.png'" alt="">
            </div>
            <div class="text-left mx-5 w-75">
                <div class="step"><h1>About Us</h1></div> <hr>
                <div class="paragraph">
                    <p>
                        An e-commerce platform that serves as a reverse marketplace for daily consumer products. The platform is inspired to enhance both sellers and buyers experiences in shopping and selling products online. We put the power for the buyers to be as specific or general as necessary and allow them to set their budget request in order to acquire their needs. 
                        <br/><br/>
                        Built with an agile and simple shopping concept while maintaining the quality value to the users. Say no more spending much time on looking for the products that you want and start request now.
                    </p>
                </div>
                <a href="/requests/create"><div class="shopbutton">Shop Now</div></a>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
    .warpper{
        text-align: center;
        height: calc(100vh - 50px);
    }
    .sectiontitle{
        font-weight: 600;
    }
    .contentwarpper{
        display: flex;
        justify-content: center;
        align-items: center;
        width: 60%;
        margin: 80px auto 0 auto;
    }
    .step h1{
        font-weight: 200;
    }
    .title h4{
        font-weight: 700;
        color: #134153;
    }
    .paragraph p{
        font-weight: 400;
        color: #999999;
        line-height: 1.8em;
    }
    .shopbutton {
        cursor: pointer;
        text-align: center;
        line-height: 45px;
        margin-top: 25px;
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
    .shopbutton:hover {
        box-shadow: inset 0 0 20px rgba(190, 218, 250, .5), 0 0 20px rgba(190, 218, 250, .2);
        outline: 1px solid;
        outline-color: rgba(190, 218, 250, 0);
        outline-offset: 15px;
        text-shadow: 1px 1px 2px #2E828B; 
    }
</style>