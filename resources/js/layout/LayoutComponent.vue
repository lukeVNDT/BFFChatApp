<template>

 <div class="laycoutcomponent">
<ExampleComponent></ExampleComponent>

<ChatSection></ChatSection>

</div>

</template>

<script>
import ExampleComponent from '../components/ExampleComponent.vue';
import ChatSection from '../components/ChatSection.vue';
export default {
    data(){
        return{
            user: {},
            msg: []
        }
    },
    created(){
        this.getCurrentUser();
    },
    methods:{
        messagedata(message){
            this.msg = message;
        },
        getCurrentUser(){
            axios.get('/currentuser')
            .then((res) => {
                this.user = res.data;
                console.log(res.data);
            }).catch((err) => {
                console.log(err);
            })
        }
    },
    components:{
        ExampleComponent,
        ChatSection
    }
}
</script>