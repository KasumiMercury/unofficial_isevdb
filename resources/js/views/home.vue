<template>
	<div class="wrap">
		<div class="my-5">
			<b-card class="text-center shadow">
				<b-card-header header-tag="header" class="p-1 d-grid" role="tab" >
					<b-button v-b-toggle.accordion-1>非公式いせぶいDBとは　<i class="fas fa-chevron-down"></i></b-button>
				</b-card-header>
				<b-collapse id="accordion-1" accordion="my-accordion" role="tabpanel">
					<b-card-body>
					<p class="m-3">いせぶい非公式DBは、「異世界転生してVになりました。」、略して「いせぶい」に所属する各メンバーの可愛い声や面白いエピソード、ファンが作った切り抜きを共有するデータベース（DB)です。</p>
					<p class="m-3">本DBは各メンバーのYouTubeチャンネル、またはYouTubeにアップロードされた切り抜きの動画リンクを直接共有します。</p>
					<p class="m-3">このサイトで再生されるとダイレクトに本人のチャンネルにて再生回数が計上されます。</p>
					<p class="m-3" style="color:#E73275;font-weight:bold">動画リンクの登録はどなたでも可能です。是非、「ここの声マジ最高！」とか「このエピソード好き」や作成した切り抜きを登録してください。</p>
					<p class="m-3" style="color:#0086AD;font-weight:bold">登録フォームは各メンバーDBに設置しています。</p>
					<p class="m-3" style="color:#0086AD;font-weight:bold">アップデートで切り抜きやタイムスタンプ作成を支援する機能を追加しました。是非ご利用ください。</p>
					<p class="m-3">本DBがみなさんの推し活や彼女たちの活動の支えになりえることを願います。</p>
					<p class="m-3">Twitter共有ボタンもあるので是非ご利用ください。</p>
					<p class="m-3">製作者の時間的都合、というより根気的問題で開発は超スローペースですが今後機能拡充やデザインの改善等行います。</p>
					<p class="m-3">不具合やこんな機能あると嬉しい等ございましたら、管理人にTwitterにてメンションをいただけると幸いです。</p>
					</b-card-body>
				</b-collapse>
			</b-card>
		</div>
		<div class="my-5">
			<b-card class="text-center shadow">
				<b-card-header header-tag="header" class="p-1 d-grid" role="tab" >
					<b-button v-b-toggle.accordion-2>そもそもいせぶいって？　<i class="fas fa-chevron-down"></i></b-button>
				</b-card-header>
				<b-collapse id="accordion-2" accordion="my-accordion" role="tabpanel">
					<b-card-body>
						<p class="m-3">個人Vtuberグループ【異世界転生してVになりました。】略して【いせぶい】（いせぶい公式Twitterプロフより）</p>
						<p class="m-3">みんなが知ってる大きい箱になることを目指してみんなで頑張っています！（いせぶい公式YouTube概要欄より）</p>
						<p class="m-3">猫耳小悪魔にガンギマリ魔法少女にたんぽぽの綿毛の妖精組長に、超能力未来少女、水龍バイトリーダー、ゲーマーにゃんこ、赤ずきんにゲラ九尾、インテリ死神</p>
						<p class="m-3">とファンも改めて見るとすごいメンツな個性的で可愛く面白い個人VTuberが集まった現在急成長中のグループです。</p>
						<p class="m-3">このDBにたどり着いた方は是非巡回して気になったメンバーを覗きに行ってみてください。</p>
						<p class="m-3">このDBが貴方の推し増しの手助けになることを願います。</p>

					<b-button class="m-1" :style="'background-color: #c4302b; border-color:#c4302b;'" :href="'https://www.youtube.com/channel/UC7JnbgdpZKohbBc9H-LaveA'">いせぶい公式YouTube</b-button>
					<b-button class="m-1" :style="'background-color: #00acee; border-color:#00acee;'" :href="'https://mobile.twitter.com/isev_info'">いせぶい公式Twitter</b-button>
					</b-card-body>
				</b-collapse>
			</b-card>
		</div>
		<div class="my-5">
			<b-card class="text-center shadow">
				<b-card-header>
					<h3>各メンバーの非公式DB</h3>
				</b-card-header>
				<b-card-body>
						<div class="container my-4" v-for="(groups,index) in BtnGroup" :key="'Group'+index">
							<div class="w-100" v-for="(member, index) in groups" :key="'Btn'+index">	
									<div class="w-100 d-grid gap-2">
										<b-button size="lg" class="m-1 btngroup" :key="'BtnGroup'+index" :style="'background-color:'+member.ImageCol+';'" v-on:click="trans(member.name)">{{member.display}}</b-button>
									</div>
							</div>
						</div>
				</b-card-body>
			</b-card>
		</div>
		<div class="my-5">
			<b-card class="text-center shadow">
				<h4>非公式いせぶいDB内新着順</h4>
				<p>スマホは表を横にスライドできます</p>
				<b-table
					responsive
					hover
					:items="limitedPlayers" :fields="fields"
					:sort-by.sync="sortBy"
					:sort-desc.sync="sortDesc"
					:style="'white-space : nowrap;'"
					>
					<template #cell(num)="data">
						{{ data.index + 1 }}
					</template>
					<template #cell(formatted_date)="data">
						{{ data.item.date | moment("YYYY/MM/DD")  }}
					</template>
					<template #cell(play)="data">
						<b-button v-if="data.item.status == 2" disabled size="sm"> private
						</b-button>
						<b-button v-else-if="data.item.status == 1" size="sm" class="member" v-on:click="$router.push('/top/player/'+data.item.id)"> MemberOnly
						</b-button>
						<b-button v-else size="sm" class="play" v-on:click="$router.push('/top/player/'+data.item.id)"><i class="fas fa-play fa-fw"></i> Player
						</b-button>
					</template>
					<template #cell(edit)="data">
						<p class="mr-1">{{ data.item.status }}
						</p>
					</template>
				</b-table>

			</b-card>
		</div>
		<div class="my-5">
			<b-card class="text-center shadow">
				<b-card-body>
					<p style="margin-bottom: 0.1rem; font-size: 0.5rem;">当サイト内コンテンツの著作権、肖像権は、<br> すべて、個人VTuberグループ「いせぶい」及びその所属メンバーに帰属します。</p>
			        <p style="margin-bottom: 0.5rem; font-size: 0.6rem;">管理人：@Mmazoku_media</p>
				</b-card-body>
			</b-card>
		</div>
	</div>
</template>
<script>
import PlayerModal from "./PlayerModal";
export default {
		data(){
			return{
				sortBy: 'id',
				sortDesc: true,
				fields: [
				{key: 'num', label: 'No.'},
				{key: 'title', label: 'TITLE', sortable: true},
				{key: 'play', label: 'PLAY'},
				{key: 'formatted_date', label: 'DATE', sortable: true},
				{key: 'id', label: 'PlayerID', sortable: true},
				],
				response:[],
				players: [],
				members: []
			}
		},
		created(){
			var self = this
			axios.get('/api/home')
				.then(function(response){ 
					self.players = response.data.players
					self.members = response.data.members
					})
				.catch(error => console.log(error));
		},
		methods:{
			trans(member,id){
				location.href = '/'+member+'/1'
			}
		},
    	components: { 
			PlayerModal 
		},
		computed: {
			limitedPlayers(){
				return this.players.slice(-10)
			},
			BtnGroup(){
				const base = this.members.length
				const split_cnt = 5
				const BtnGroup = []
				for (let i=0; i<Math.ceil(base/split_cnt); i++) {
				let multiple_cnt = i * split_cnt
				let result = this.members.slice(multiple_cnt, multiple_cnt + split_cnt) 
				BtnGroup.push(result)
				}
				return BtnGroup
			}
		}
}
</script>

<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Yusei+Magic&family=Zen+Maru+Gothic&display=swap');
body{
	font-family: 'Zen Maru Gothic', sans-serif;
	background-color: #B6CDF7 !important;
}
.btngroup{
	font-family: 'Yusei Magic', sans-serif;
	color:rgb(43, 21, 8); 
	text-shadow:2px 2px 2px #eee;
	border-color: #ccc;
}
.btngroup:hover{
	color: #ccc;
}
.play{
	background-color: #c4302b;
	border-color: #c4302b;
}
.member{
	background-color: #70b87c;
	border-color: #70b87c;
}
.sr-only{
	display:none;
}
.wrap{
	background-color: #B6CDF7 !important;
}
.wrap div{
	background-color: #eee;
}
</style>