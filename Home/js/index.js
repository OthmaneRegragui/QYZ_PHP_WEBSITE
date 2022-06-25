
function CheckNotVoid(List=[]){
    let b=true;
    List.map(function(x){if(x.length==0){b=false}})
    return b
}




$(document).ready(
    function(){
        const GroupName_Create=document.getElementById('GroupName_Create');
        const Description=document.getElementById('Description_CreateGroup');
        const isPrivate=document.getElementById('isPrivate');
        const AllowUsersToSendJoinRequest=document.getElementById('AllowUsersToSendJoinRequest');
        const Alert=document.getElementById('Alert')
        $('#ModalCreateGroupbtn').click(function(){
            Alert.innerHTML='';
            if(CheckNotVoid([GroupName_Create.value])){
                $.ajax({
                    type:'POST',
                    url:'./CreateGroup.php',
                    data:{
                        GroupName:$('#GroupName_Create').val(),
                        Description:$('#Description_CreateGroup').val(),
                        AllowUsersToSendJoinRequest:AllowUsersToSendJoinRequest.checked,
                        isPrivate:isPrivate.checked
                    },success:function(data){
                        data=data.split('\n')[0];
                        if(data.includes('Succeed')){
                            Alert.setAttribute('class','alert alert-success')
                            Alert.setAttribute('role','alert')
                            Alert.textContent='Group Created'
                            GroupName_Create.value='';
                            Description.value='';
                        }
                        else if(data.includes('Error')){
                            Alert.setAttribute('class','alert alert-danger')
                            Alert.setAttribute('role','alert')
                            Alert.textContent='Group Not Created Plz Try Again'
                        }
                        else{
                            Alert.setAttribute('class','alert alert-danger')
                            Alert.setAttribute('role','alert')
                            Alert.textContent='Group Not Created Plz Try Again'
}}});}})})

function SendGroupRequest(GroupId){
    $.ajax({
        type:'POST',
        url:'./SendGroupRequest.php',
        data:{
            Target:GroupId,
        },success:function(data){
            $('#AlertRe').html('')
            if (data.includes('True')){
                $('#AlertRe').addClass('alert alert-success')
                $('#AlertRe').text('Request To Group Are Send')
            }
        }
    })
}




function SearchGroups(Target,SearchBy){
    const SearchResultList=document.getElementById('SearchResultList');
    if(Target.length!=0){
        $.ajax({
                    type:'POST',
                    url:'./SearchGroups.php',
                    data:{
                        Target:Target,
                        SearchBy:SearchBy,
                    },success:function(data){
                        SearchResultList.innerHTML='';
                        data = JSON.parse(data);
                        data.map(function(x){
                            
                            let button=document.createElement('button');
                            button.setAttribute('type','button');
                            button.setAttribute('class','btn btn-secondary SearchBtnSend');
                            button.textContent='Send Request';

                            let li=document.createElement('li');
                            li.setAttribute('class','list-group-item list-Search');
                            li.innerHTML=`Id:${x.id} Name:${x.GName} Description:${x.GDescription}`;

                            button.onclick=function(){
                                SendGroupRequest(x.id)
                                SearchResultList.removeChild(li);
                            }




                            li.appendChild(button);
                            SearchResultList.appendChild(li);
                        })
                        
                    }
        })
    }
    else{
        SearchResultList.innerHTML='';
    }

}

const input = document.getElementById('InputSearch');
const log = document.getElementById('text');
const SelectSeachBy = document.getElementById('SelectSeachBy');

var SelectSeachValue='id'
if(SelectSeachBy!=null){
SelectSeachBy.addEventListener('change', (event) => {
    SelectSeachValue=event.target.value;
    SearchGroups(log.textContent,SelectSeachValue)
});
input.addEventListener('input', function () {
    log.textContent = this.value;
    SearchGroups(this.value,SelectSeachValue)
});
}

