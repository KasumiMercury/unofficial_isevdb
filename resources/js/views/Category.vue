<template>
	<div>

		<template>
		<div class="accordion my-1" role="tablist">
			<b-card no-body class="mb-1" :style="'background-color:'+current_member.SubCol+';'">
			<b-card-header header-tag="header" class="p-1 d-grid" role="tab" >
				<b-button v-b-toggle.accordion-1 class="btn" :style="'background-color:'+current_member.BtnCol +';'">非公式{{current_member.display}}DBとは</b-button>
			</b-card-header>
			<b-collapse id="accordion-1" accordion="my-accordion" role="tabpanel">
				<b-card-body>
					<p class="m-2">いせぶい{{current_member.display}}非公式DBは、「異世界転生してVになりました。」、略して「いせぶい」に所属する{{current_member.display}}の可愛い声や面白いエピソード、恋惡まよのファンであるま族が作った切り抜きを共有するデータベース（DB)です。</p>
					<p class="m-2">本DBはYouTube{{current_member.display}}チャンネル、またはYouTubeにアップロードされた切り抜きの動画リンクを直接共有します。</p>
					<p class="m-2">このサイトで再生されるとダイレクトに本人のチャンネルにて再生回数が計上されます。</p>
					<p  class="m-2" style="color:#E73275;font-weight:bold">動画リンクの登録はどなたでも可能です。是非、「ここの声マジ最高！」とか「このエピソード好き」や作成した切り抜きを登録してください。</p>
					<p class="m-2">本DBがみなさんの推し活や彼女の活動の支えになりえることを願います。</p>
					<p class="m-2">Twitter共有ボタンもあるので是非ご利用ください。</p>
					<p  class="m-2" :style="'color: #E9546B'">アップデートで個別のプレイヤー画面が設置しました。</p>
					<p  class="m-2">製作者の時間的都合、というより根気的問題で開発は超スローペースですが今後機能拡充やデザインの改善等行います。</p>
					<p class="m-2">不具合やこんな機能あると嬉しい等ございましたら、下のTwitterボタンから製作者にメンションをいただけると幸いです。</p>
				</b-card-body>
			</b-collapse>
			</b-card>

			<b-card no-body class="mb-1" :style="'background-color:'+current_member.SubCol+';'">
			<b-card-header header-tag="header" class="p-1 d-grid" role="tab">
				<b-button v-b-toggle.accordion-2 class="btn" :style="'background-color:'+current_member.BtnCol +';'">{{current_member.display}} info</b-button>
			</b-card-header>
			<b-collapse id="accordion-2" accordion="my-accordion" role="tabpanel">
				<b-card-body>
					<b-button class="m-1" :style="'background-color: #c4302b; border-color:#c4302b;'" href="https://www.youtube.com/channel/UCjlO0QCarccGehZqm6rhnSQ">{{current_member.display}}　YouTube</b-button>
					<b-button class="m-1" :style="'background-color: #00acee; border-color:#00acee;'" href="https://twitter.com/koaku_mayo">{{current_member.display}}　Twitter</b-button>
				</b-card-body>
			</b-collapse>
			</b-card>

			<b-card no-body class="mb-1" :style="'background-color:'+current_member.SubCol+';'">
			<b-card-header header-tag="header" class="p-1 d-grid" role="tab">
				<b-button v-b-toggle.accordion-3 class="btn" :style="'background-color:'+current_member.BtnCol +';'">How to use</b-button>
			</b-card-header>
			<b-collapse id="accordion-3" accordion="my-accordion" role="tabpanel">
				<b-card-body>
					<p>まず「Voice」「Episode」などからカテゴリーを選びます。</p>
					<p>リストから見たいものの「Player」ボタンを押すとプレイヤー画面に飛びます。</p>
					<p>スマホの場合はリストを横にスライドできます。</p>
					<p>「Title」「Date」「PlayerID」の見出しをタップすると昇順・降順に並び替えができます。</p>
					<p>並び替えをリセットしたい時は「No.」をタップしてください。デフォルトは新着順です。</p>
					
					<div class="d-grid mx-2 my-5">
					<p class="my-1">データ登録はこちらから！</p>
						<button class="btn p-2" :style="'background-color:'+current_member.BtnCol +'; border-color'+current_member.BtnCol +';'" v-on:click="$router.push('/'+member+'/add')">
							データを追加/<br>
							切り抜き・タイムスタンプ支援ツール
						</button>
					</div>   
				</b-card-body>
			</b-collapse>
			</b-card>
		</div>
		</template>



		<b-card class="custom my-2" :style="styles">  
			<b-card-header header-tag="nav" class="custom">
				<b-nav card-header tabs justified>
					<b-nav-item v-for="category in categories" :key="category.id" :to="'/'+$route.params.member+'/'+category.id">
						{{ category.title }}
					</b-nav-item>
				</b-nav>
			</b-card-header>
			<b-card-body class="text-center p-0">
					<div class="p-3">
						<div v-for="category in categories" :key="category.id" class="m-3">
							<h3 v-if="cate == category.id">{{category.title}} Category</h3>																																																																										
						</div>
						<div class="my-5">
							<router-view>
							</router-view>
						</div>
					</div>
					<div class="d-grid m-3">
						<button class="btn p-2" v-on:click="$router.push('/'+member+'/add')">
							データを追加/<br>
							切り抜き・タイムスタンプ支援ツール
						</button>
					</div>   
			</b-card-body>   
		</b-card>
	</div>
</template>
<script>
export default {
		props:['categories','current_member'],
		data(){
			return{
				member:	this.$route.params.member,
				cate: this.$route.params.cate,				
			}
		},
		beforeRouteUpdate (to, from, next) {
			this.cate = to.params.cate
			next()
		},
		computed: {
			styles () {
			return {
				'--SubCol': this.current_member.SubCol,
				'--BtnCol': this.current_member.BtnCol
			}
			}
		}
}
</script>
<style lang="scss" scoped>
.custom{
	background-color: var(--SubCol);
	border-color: var(--BtnCol);
}
.nav-tabs > li > a {
	font-size: 15px;
	color: #000;
}
.nav-tabs > li :hover{
	color:  var(--BtnCol);
	border-color: var(--BtnCol);
}
.btn {
	background-color: var(--BtnCol);
	color: #eee;
}
button{
	background-color: var(--BtnCol);
	color: #eee;
	}
</style>