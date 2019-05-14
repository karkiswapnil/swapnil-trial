export default class Gate{
    constructor(user){
        this.user=user;

    }

    isAdmin(){
        return this.user.role ==='admin';
    }
    isUser(){
        return this.user.role ==='user';
    }
    isMember(){
        return this.user.role ==='member';
    }
}