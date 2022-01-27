<template>
	<div class="text-center">
        <b-card class="custom p-3 mt-4 BG" v-bind:style="styles">
            <h1 class="mb-5">データ追加/<br>切り抜き・タイムスタンプ支援ツール</h1>
            <Addstep1 v-if="stepNumber === 1" @addURL="updateURL" :member="current_member"></Addstep1>
            <Addstep2 v-if="stepNumber === 2" v-bind:form="form" :members="members" :current_member="current_member" v-on:from-child="updateURL" v-on:from-child1="nextStep" v-on:from-child2="backStep"></Addstep2>
            <Addstep3 v-if="stepNumber === 3" v-bind:form="form" :categories="categories" :current_member="current_member" v-on:from-child2="backStep" ></Addstep3>
	    </b-card>
    </div>
</template>
<script>
import Addstep1 from './add_step1.vue'
import Addstep2 from './add_step2.vue'
import Addstep3 from './add_step3.vue'
import Addstep4 from './add_step4.vue'
export default {
		props:['categories','current_member','members'],
		data(){
			return{
                stepNumber:1,
				cate: this.$route.params.cate,
                form: {
                    YTurl: "",
                    VideoID: "",
                    Title: "",
                    Date: "",
                    IsSelect: false
                }
			}
		},
		computed: {
			styles () {
			return {
				'--SubCol': this.current_member.SubCol,
				'--BtnCol': this.current_member.BtnCol
			}
			}
		},
        methods:{
            updateURL:function(formData){
                Object.assign(this.form, formData);
		        this.stepNumber++;
            },
            backStep(){
		        this.stepNumber--;
            },
            nextStep(){
		        this.stepNumber++;
            }
        },
        components: {
            Addstep1,
            Addstep2,
            Addstep3,
            Addstep4
        },
        scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
        }
}
</script>
<style scoped>
.BG{
	background-color: var(--SubCol) !important;
}
</style>