<template>
	<div id="app">
		<b-card title="Card Title" class="my-3" no-body>
			<b-card-header class="text-center">
				<h2>{{playerInfo.title}}</h2>
			</b-card-header>
			<b-card-body class="text-center p-3">
				<div id="Wrapper">
				</div>
				<div class="m-2 my-4">
				<b-button pill size="sm" variant="outline-primary" v-on:click="show">
					メン限/非公開報告・削除申請
				</b-button>
				</div>
				<div class="m-1">
					<p>タイトル：</p>
					<p>{{playerInfo.VideoTitle}}</p>
					<p>投稿日：{{playerInfo.date}}</p>
				</div>
				<div class="d-grid m-3">

				<ShareNetwork
					network="twitter"
					:url="Tweet.url"
					:title="Tweet.title"
					:hashtags="Tweet.hash"
					>
				<div class="d-grid m-3">
				<b-button class="p-3 mt-3 btn-Tweet">Tweet</b-button>
				</div>
				</ShareNetwork>
				</div>
				<div class="d-grid m-3">
				<b-button size="lg" class="p-3" v-on:click="$router.push('/'+member+'/'+playerInfo.cate_id)">
					-> Data List
				</b-button>
				</div>
			</b-card-body>   
		</b-card>
		<EditModal :id="this.id" :status="playerInfo.status" :player="playerInfo"  v-on:from-child="hide" v-on:from-child2="edited"/>
		<modal name="completed" class="text-center">
            <div class="my-5">
                <p>送信完了しました！</p>
                <p>ご協力ありがとうございます！</p>
            </div>
            <b-button class="m-3" v-on:click="$router.push('/'+current_member.name+'/1')">トップへ</b-button>
            <b-button class="m-3" @click="hidecomp">閉じる</b-button>
        </modal>
	</div>
</template>
<script>
import EditModal from './edit.vue'
export default {
		props:["id","current_member"],
		data(){
			return{
				Tweet:{},
				member: this.$route.params.member,
				playerInfo:[],
                iframe_F:'<iframe width="560" height="315" src="https://www.youtube.com/embed/',
                iframe_S:'?start=',
                iframe_E:'&end=',
                iframe_L:'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
			}
		},
		created(){
			var self = this
			axios.get('/api/root/player/' + this.id)
				.then(function(response){
					self.playerInfo = response.data.data
					let tag = self.iframe_F+self.playerInfo.VideoID+self.iframe_S+self.playerInfo.start+self.iframe_E+self.playerInfo.end+self.iframe_L
					document.getElementById('Wrapper').innerHTML = tag
					self.Tweet["url"] = "https://www.youtube.com/watch?v="+self.playerInfo.VideoID
					self.Tweet["title"] = "非公式:"+self.current_member.display+"DB No."+self.id+":https://isevdb.sakura.ne.jp/"+self.member+"/player/"+self.id
					self.Tweet["hash"] = "いせぶい非公式DB,"+self.current_member.display+"非公式DB,"+self.current_member.display
				})
				.catch(error => console.log(error));
		},
		methods: {
			show() {
			this.$modal.show('edit_modal');
			},
			hide() {
			this.$modal.hide('edit_modal');
			},
			edited() {
			this.$modal.hide('edit_modal');
            this.$modal.show('completed');
			},
			hidecomp() {
			this.$modal.hide('completed');
			}
		},
        computed:{
            player(){
                return this.$refs.youtube.player
            }
        },
		components: {
			EditModal
		}
}
</script>
<style>
.btn-Tweet {
	background-color: #00acee;
	border-color: #00acee;
}
#Wrapper{
	position: relative !important;
	width: 100%;
	height: 0 !important;
	padding-top: 56.25% !important;
	overflow: hidden;
}
iframe{
	width: 100%;
	height: 100%;
	position: absolute;
	top: 0;
	left: 0;
}
</style>