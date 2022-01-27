<template>
	<div id="app">
		<b-card title="Card Title" class="my-3" no-body>
			<b-card-header class="text-center">
				<h2>{{player.title}}</h2>
			</b-card-header>
			<b-card-body class="text-center p-3">
				<div id="Wrapper" v-if="player.start == 0">
					<iframe width="560" height="315" :src="'https://www.youtube.com/embed/'+player.VideoID+'?start=1&end='+player.end" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
				<div id="Wrapper" v-else>
					<iframe width="560" height="315" :src="'https://www.youtube.com/embed/'+player.VideoID+'?start='+player.start+'&end='+player.end" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
				<div class="m-2 my-4">
				<b-button pill size="sm" variant="outline-primary" v-on:click="show">
					メン限/非公開報告・削除申請
				</b-button>
				</div>
				<div class="m-1">
					<p>タイトル：</p>
					<p>{{player.VideoTitle}}</p>
					<p>投稿日：{{player.date}}</p>
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
				<b-button size="lg" class="p-3" v-on:click="$router.push('/'+member+'/'+player.cate_id)">
					-> Data List
				</b-button>
				</div>
			</b-card-body>   
		</b-card>
		<EditModal :id="this.id" :status="player.status" :player="player"  v-on:from-child="hide" v-on:from-child2="edited"/>
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
				player:[],
			}
		},
		created(){
			axios.get('/api/root/player/' + this.id)
				.then(response => this.player = response.data.data)
				.catch(error => console.log(error));
			this.Tweet["url"] = "https://isevdb.sakura.ne.jp/"+this.member+"/player/"+this.id
			this.Tweet["title"] = "いせぶい非公式:"+this.current_member.display+"DB No."+this.id
			this.Tweet["hash"] = "いせぶい非公式DB,"+this.current_member.display+"非公式DB,"+this.current_member.display
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