<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form @submit.prevent="send()" method="POST">
                    <ul class="list-group" v-chat-scroll="{smooth: true}">
                        <li class="list-group-item" v-for="chat in chats" :key="chat.id">{{ chat.message }}</li>
                    </ul><br>
                    <input type="text" v-model="message" class="form-control" placeholder="Write here...">
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted(){
        Echo.private('home')
            .listen('ChatEvent', (e) => {
                this.getall();
            })
            .listenForWhisper('typing', (e) => {
                this.getall()
            });

        Echo.join('home')
            .here((users) => {
                console.log(users.length);
            })
            .joining((user) => {
                this.$toaster.success(user.name+' is joined')
            })
            .leaving((user) => {
                this.$toaster.warning(user.name+' is Leaved');
            });

            this.getall();
        
        },
        watch:{
            message(){
                Echo.private('home')
                .whisper('typing', {
                    message: this.message
                });

            }
        },
        data(){
            return{
                message : '',
                chats : [],
            }
        },
        methods:{
            send(){
                if(this.message != ''){
                    axios.post('store', {
                        message : this.message
                    })
                    .then(response =>{
                        this.message = ''
                        this.getall()
                    })
                    .catch(error =>{
                        console.log(error);
                    })
                }
            },
            getall(){
                axios.get('/all')
                    .then(response =>{
                        this.chats = response.data
                    })
                    .catch(error =>{
                        console.log(error);
                    })
            }
        }
    }
</script>
<style scoped>
    .list-group{
        overflow-y: scroll;
        height: 289px;
    }
</style>
