<template>
    <div id="app" class="burgerWrap">
        <b-button  v-b-toggle.sidebar-backdrop class="shadow rounded-circle p-0 border-2 burgerBtn" :style="styles"><i class="fas fa-bars" style="font-size: 1.5rem;"></i></b-button>
        <b-sidebar
        id="sidebar-backdrop"
        title="Menu"
        :backdrop-variant="'dark'"
        backdrop
        shadow
        no-header
        >
            <template #footer="{ hide }">
                <div class="d-flex bg-dark text-light align-items-center px-3 py-2">
                <b-button size="sm" class="me-0 ms-auto" @click="hide">Close</b-button>
                </div>
            </template>

            <div class="py-2 h-100" :style="'background-color:'+current_member.MainCol+';'">
                <div class="d-grid">
                    <div class="text-center">
                        <p>非公式DB一覧</p>
                    </div>
                    <template v-for="(member,index) in members">
                        <b-button block squared :key="'BtnGroup'+index" class="mt-1 px-4 text-start" :style="'background-color:'+member.BtnCol+';'" v-on:click="trans(member.name)">{{member.display}}DB</b-button>
                    </template>
                        <b-button block squared class="mt-1 px-4 text-start" @click="top">非公式いせぶいDBトップ</b-button>
                        <b-button block size="lg" squared class="mt-3 px-4 text-start" v-on:click="$router.push('/'+current_member.name+'/add')">非公式{{current_member.display}}DBに<br>データを追加</b-button>
                </div>
            </div>
        </b-sidebar>
    </div>
</template>
<script src="https://kit.fontawesome.com/030c12cd3e.js" crossorigin="anonymous"></script>
<script>
export default {
    props:['members','current_member'],
    methods:{
        trans(member){
            location.href = '/'+member+'/1'
        },
        top(){
            location.href = '/'
        }
    },
	computed: {
		styles () {
		return {
			'--MainCol': this.current_member.MainCol,
			'--BtnCol': this.current_member.BtnCol
		}
		}
	}
}
</script>
<style lang="scss" scoped>
.burgerBtn{
    width:3rem !important;
    height:3rem !important;
	background-color: var(--MainCol) !important;
	border-color: var(--BtnCol)!important;
    color: var(--BtnCol);
}
.close{
    background-color: rgba($color: #000000, $alpha: 0);
}
.close svg{
    background-color: rgba($color: #000000, $alpha: 0);
}
</style>