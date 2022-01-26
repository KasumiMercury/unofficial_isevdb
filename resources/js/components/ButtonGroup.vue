<template>
    <div id="app" class="BGroup text-center">
        <div>
            <h6 class="mt-2 mb-1">非公式いせぶいDB</h6>
        </div>
        <b-button-group>
            <template v-for="(member,index) in members" class="col-md-auto">
                <b-button :key="'BtnGroup'+index" size="sm" :style="'background-color:'+member.BtnCol+';'" v-on:click="trans(member.name)">{{member.display}}</b-button>
            </template>
        </b-button-group>
    </div>
</template>
<script>
export default {
    props:['members'],
    methods:{
        trans(member){
            location.href = '/'+member+'/1'
        }
    }
}
</script>
<style scoped>
.Bgroup{
    width:100vw;
}
</style>