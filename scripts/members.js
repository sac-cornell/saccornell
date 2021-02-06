function openModal(box) {
    console.log();
    document.getElementById(box).classList.remove('hidden');
}

function closeModal(box) {
    document.getElementById(box).classList.add('hidden');
}

function openMemberForm() {
    document.getElementById('editMembers').classList.remove('hidden');
}

function closeMemberForm() {
    document.getElementById('editMembers').classList.add('hidden');
}
