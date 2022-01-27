<template>
    <div id="app">
        <modal name="AddClipping" :height="'auto'" :scrollable="true" :resizable="true">
            <b-form-group class="m-5" label="ハンドルネームを設定してください（削除時の照合に使います）">
                <b-form-input type="text" class="form-control" v-model="CreaterHN" placeholder="name"></b-form-input>
                <b-button size="lg" class="m-3" @click="submit">登録</b-button>
            </b-form-group>
        </modal>
    </div>
</template>
<script>
export default {
    props: ['form','current_member'],
    data(){
        return{
            CreaterHN:"",
            SendArray:[],
            results: null, 
            params: {
                id: "",
                key: "AIzaSyCv9gZE-50Vj3fVj1dgk0IPv0O1MoDsiHI",
                part: "snippet",
            }
        }
    },
    methods: {
        submit(){
                this.params.id = this.form.VideoID
                var self = this;
                axios
                    .get("https://www.googleapis.com/youtube/v3/videos", {
                        params: this.params
                    })
                    .then(function(res) {
                            self.results = res.data.items[0].snippet
                            self.SendArray.push({title: self.results.title,date: self.results.publishedAt,VideoID: self.form.VideoID,VideoTitle: self.results.title,start: 0,end: 0,status: 0,cate_id: 4,member_id: self.current_member.id,CreaterHN: self.CreaterHN,created_at:new Date(),updated_at:new Date()})
                            console.log(self.SendArray)
                            axios({
                                method: 'post',
                                url: '/api/'+self.$route.params.member+'/clip',
                                dataType: 'json',
                                data: self.SendArray
                            })
                            .then(response => {
                            console.log(response)
                            self.$emit('from-child')
                            })
                            .catch(error => {
                            console.log(error)
                            })
                        })
            .catch(error => {
            console.log(error)
            }) 
        }
    },
    scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
    }
}
</script>