<template>
        <div id="app">
                <h3 class="m-2">YouTubeのURLを入力してください</h3>
            <b-form-group>
                <div class="m-2" style="color:#E9546B;">
                <p>YouTubeで「共有」ボタンからURLを取得すると確実です。</p>
                <p>ちなみにYouTube内の「共有」から共有するとAnalyticsに反映されるそうです。</p>
                </div>

                <b-form-input type="text" class="form-control" v-model="YTurl" placeholder="YouTube URL"></b-form-input>
                <b-button class="m-5" @click="submit">OK!!</b-button>
            </b-form-group>

            <b-button v-if="Search == false" @click="search_video" v-b-toggle.collapse class="m-1">新着動画から選択する</b-button>
            <b-button v-else  @click="search_video_shut" v-b-toggle.collapse class="m-1">閉じる</b-button>

                <b-collapse id="collapse">
                    <b-card>
                        <p>スマホは表を横に<br>スライドしてください</p>
                        <b-table
                            responsive
                            :items="results" :fields="fields"
                            >
                            <template #cell(img)="data">
                                <img width="120" height="90" v-bind:src="data.item.snippet.thumbnails.default.url">
                            </template>
                            <template #cell(button)="data">
                                <b-button @click="SelectVideo(data.item.id.videoId,data.item.snippet.title,data.item.snippet.publishTime)">選択</b-button>
                            </template>
                        </b-table>
                    </b-card>
                </b-collapse>

            <modal name="error-modal">
                <div  :height="30" :width="'50%'">
                    <h2 class="m-4">エラー</h2>
                    <div class="w-100">
                        <p class="my-2">無効なURLが入力されました。YouTubeのURLを入力してください。</p>
                        <p class="my-1">「https://www.youtube.com/watch?v=」または「https://youtu.be/」から始まるURL</p>
                    </div>
                    <b-button class="m-3" @click="back">戻る</b-button>
                </div>
            </modal>
        </div>
</template>
<script>
export default {
        props:['member'],
		data(){
			return{
                YTurl: "",
                form: {
                    YTurl: "",
                    VideoID: "",
			    },
                Search: false,
                results: null,
                params: {
                    channelId: "",
                    part: "snippet",
                    type: "video",
                    maxResults: "10",
                    order: "date",
                    key: "AIzaSyB-0dTX7t8Z23Kel6euLvpZw6AWdd1goHs"
                },
				fields: [
                    {key: 'img', label: 'サムネ'},
                    {key: 'button', label: '選択'},
                    {key: 'snippet.title', label: 'Title'},
				],
            }
		},
        created(){
            this.params.channelId = this.member.ChannelID
        },
        methods: {
            submit: function(){
                let isShort =this.YTurl.indexOf('watch');
                if (isShort != -1) {
                    let WhereS = this.YTurl.indexOf('=') + 1;
                    let WhereTime = this.YTurl.indexOf('&t');
                    if (WhereTime != -1){
                        var createID = this.YTurl.slice(WhereS,WhereTime)
                    }else{
                        var createID = this.YTurl.slice(WhereS)
                    }
                } else {
                    let WhereDomain = this.YTurl.indexOf('youtu.be/') + 9;
                    let WhereTime = this.YTurl.indexOf('?t=');
                    if (WhereTime != -1){
                        var createID = this.YTurl.slice(WhereDomain,WhereTime)
                    }else{
                        var createID = this.YTurl.slice(WhereDomain)
                    }
                }
                
                if (createID == ""){
                    this.$modal.show('error-modal');
                }else{
                    this.$emit('addURL',{
                        YTurl: this.YTurl,
                        VideoID: createID,
                        IsSelect: false,
                        Title: "",
                        Date:""
                    }
                    );
                }
            },
            back(){
                this.$modal.hide('error-modal');
            },
            search_video: function() {
            var self = this;
            console.log("clicked")
            this.Search = true
            axios
                .get("https://www.googleapis.com/youtube/v3/search", {
                params: this.params
                })
                .then(function(res) {
                self.results = res.data.items;
                })
            },
            search_video_shut(){
                this.Search = false
            },
            SelectVideo(id,title,date){
                console.log(id)
                this.IsSelect = true
                this.$emit('addURL',{
                        YTurl: id,
                        VideoID: id,
                        IsSelect: true,
                        Title: title,
                        Date: date,
                    })
            }
        }
}
</script>