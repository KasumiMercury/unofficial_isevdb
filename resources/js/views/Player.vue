<template>
    <div>
        <PlayerModal :id="id" :current_member="current_member"/>
    </div>
</template>
<script>
import PlayerModal from "./PlayerModal";
export default {
	props:['current_member'],
	data(){
		return{
			id: this.$route.params.id,
			member: this.$route.params.member,
		}
	},
    components: { PlayerModal }
};
</script>