import '../css/UserProfile.css';
import cog from '../img/cog.svg';
function UserProfile(){
    var currentUserID = 1;
    var userID = 1;
    const userData = {
        username: "John",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sed mauris eget eros dignissim eleifend. Proin vitae sem consequat, gravida sapien vitae, auctor erat. Sed accumsan at neque ac scelerisque. Etiam ut leo sed odio fringilla aliquam. Nam feugiat consequat tempor. Aliquam at gravida odio. Aliquam at mollis arcu, et vulputate eros. Nullam lectus justo, accumsan sagittis turpis aliquam, suscipit pharetra risus. Ut imperdiet augue in felis accumsan, vitae elementum lectus dapibus. Donec mattis rutrum libero sed dictum. Curabitur finibus eros ex, et lobortis est vestibulum tempor. Morbi congue eu quam eu condimentum. Nulla non diam nec elit hendrerit maximus. Quisque finibus lacus ac justo pellentesque placerat. Aliquam efficitur vel odio eget tempor. Curabitur pharetra enim sit amet euismod tempor. ",
        password: "password123",
        email: "john.smith@email.com",
        date:"01.01.2000",
        friends: [1,2,3],
        pins: ["pin1", "pin2"],
        categories: ["cat1", "cat2"],
        
    }
    return (
        <div className="UserProfile">
            {userID == currentUserID &&
            <div className='settings-dropdown'>
                <img className='settings-icon' src={cog} alt="settings cog wheel"/>
                    <ul className='settings-menu'>
                        <li>Change name</li>
                        <li>Change description</li>
                        <li>Change email</li>
                        <li>Change password</li>
                    </ul>
            </div>
            }
            
            <div className="topContainer">
                <div className="profile-bg"></div>
                <div className="profile-img"><img></img></div>
            </div>
            <div className='bottomContainer'>
                <div className="nameHolder">
                    <h1 className="profile-name">{userData.username}</h1>
                    {userID != currentUserID && !userData.friends.includes(userID) &&
                    <button className="addFriend-btn" role="button"><span className="text">{}Add Friend</span></button>
                    }
                </div>
                <span className="profile-date">Joined: {userData.date}</span>
                <p className="profile-description">{userData.description}</p>
                <section>
                    <h2>Favorite Categories</h2>
                    <p>{userData.categories.map((cat) => {
                        return (
                            <span><a href="#">{cat}</a> </span>
                        )
                    })}</p>
                </section>
                <section>
                    <h2>Pins</h2>
                    <p>{userData.pins.map((pin) => {
                        return (
                            <span><a href="#">{pin}</a> </span>
                        )
                    })}</p>
                </section>
            </div>
        </div>
    );
}

export default UserProfile