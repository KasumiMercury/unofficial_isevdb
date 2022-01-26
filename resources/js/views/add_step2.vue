<template>
	<div class="m-auto">
        <b-card>
            <b-aspect aspect="16:9">
                <youtube :video-id="form.VideoID" ref="youtube" @playing="playingVideo"></youtube>
            </b-aspect>
        </b-card>
        <div>
            <b-button class="m-3" @click="pauseVideo" v-if="playing">pause</b-button>
            <b-button class="m-3" @click="playVideo" v-else>play</b-button>
            <div class="w-100">
                <b-button @click="next">この動画で進む</b-button>
                <b-button @click="back">戻る</b-button>
            </div>
            <b-button class="m-2" @click="AddClip">切り抜きの登録はこちらから！</b-button>
        </div>
        <modal name="error-modal">
                <div  :height="30" :width="'50%'">
                    <h2 class="m-4">エラー</h2>
                    <div class="w-100">
                        <p class="my-2">このサイトでは以下のチャンネル以外の<br>動画の取り扱いをお断りしています</p>
                        <p class="my-1">いせぶい公式</p>
                        <p class="my-1" v-for="member in members" :key="member.name">{{member.display}}</p>
                    </div>
                    <b-button class="m-3" @click="hidemodal">戻る</b-button>
                </div>
        </modal>
        <AddClipping :form="form" :current_member="current_member" v-on:from-child="HideClip"></addclipping>
        <modal name="completed" class="text-center">
            <div class="my-5">
                <p>送信完了しました！</p>
                <p>ご協力ありがとうございます！</p>
            </div>
            <b-button class="m-3" v-on:click="$router.push('/'+current_member.name+'/1')">トップへ</b-button>
        </modal>
    </div>
</template>

<script>
import AddClipping from './add_clipping.vue'
    export default {
        props:['form','members','current_member'],
        data(){
            return{
                playing: false,
                Path: false,
                results: null, 
                params: {
                    id: "",
                    key: "AIzaSyCv9gZE-50Vj3fVj1dgk0IPv0O1MoDsiHI",
                    part: "snippet",
                },
            }
        },
        methods:{
            playVideo(){ 
                this.player.playVideo()
                this.playing = true
            },
            pauseVideo(){ 
                this.player.pauseVideo()
                this.playing = false
            },
            playingVideo(){
                console.log('play start!')
            },
            next() {
                if(this.form.IsSelect == false){
                    this.params.id = this.form.VideoID
                    console.log(this.params.id)
                    var self = this;
                    console.log(this.params)
                    axios
                        .get("https://www.googleapis.com/youtube/v3/videos", {
                        params: this.params
                        })
                        .then(function(res) {
                            console.log(res)
                            console.log(res.data.items[0].snippet)
                            self.results = res.data.items[0].snippet
                            console.log(self.results)

                            let ChannelArray = self.members.map(item => item.ChannelID)
                            ChannelArray.push("UC7JnbgdpZKohbBc9H-LaveA")
                            let IsExist = ChannelArray.indexOf( self.results.channelId );
                            if(IsExist == -1){
                                self.Path = false
                                console.log(self.Path) 
                                self.$modal.show('error-modal');
                            }else{
                                self.Path = true
                                console.log(self.Path)
                                self.$emit('from-child',{
                                    Title: self.results.title,
                                    Date: self.results.publishedAt
                                })
                            }

                        }) 

                }else{
                    this.Path = true
                    console.log(this.Path)
                    this.$emit('from-child1')
                }
		    },
            back() {
            this.$emit('from-child2')
		    },
            hidemodal(){
                this.$modal.hide('error-modal');
            },
            AddClip(){
                this.$modal.show('AddClipping');
            },
            HideClip(){
                this.$modal.hide('AddClipping');
                this.$modal.show('completed');
            }
        },
        computed:{
            player(){
                return this.$refs.youtube.player
            }
        },
        components: {
            AddClipping
        }
    }
</script>