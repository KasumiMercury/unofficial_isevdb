<template>
    <div id="app" class="BGroup text-center p-2">
        <div>
            <h6 class="mt-2 mb-1">非公式いせぶいDB</h6>
        </div>
        <template v-for="(member,index) in members" class="row-cols-auto">
            <b-button squared class="col" :key="'BtnGroup'+index" size="sm" :style="'background-color:'+member.BtnCol+';'" v-on:click="trans(member.name)">{{member.name}}</b-button>
        </template>
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