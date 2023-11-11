import '../css/UserProfile.css'
function UserProfile(){
    return (
        <div className="UserProfile">
            <div className="topContainer">
                <div className="profile-bg"></div>
                <div className="profile-img"><img></img></div>
            </div>
            <div className='bottomContainer'>
                <div className="nameHolder">
                    <h1 className="profile-name">Name</h1>
                    <button class="addFriend-btn" role="button"><span class="text">Add Friend</span></button>
                </div>
                <span className="profile-date">Joined: Date</span>
                <p className="profile-description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi fuga aliquam voluptate, nobis quaerat reprehenderit corrupti quo quisquam nostrum debitis nemo alias non. Magni nesciunt odit deserunt esse, quod inventore!</p>
                <section>
                    <h2>Favorite Categories</h2>
                    <p>Category 1 Cat 2 etc...</p>
                </section>
                <section>
                    <h2>Pins</h2>
                    <p>Pin name1 LocationX...</p>
                </section>
            </div>
        </div>
    );
}

export default UserProfile