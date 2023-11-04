import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'main.dart';

class DashBoard extends StatefulWidget {
  const DashBoard({Key? key}) : super(key: key);

  @override
  _DashBoardState createState() => _DashBoardState();
}

class _DashBoardState extends State<DashBoard> {
  int _selectedIndex = 0; // Index of the selected tab
  String? username = '';

  @override
  void initState() {
    super.initState();
    loadUsername();
  }

  Future<void> loadUsername() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    setState(() {
      username = prefs.getString('username');
    });
  }

  void handleLogout() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();

    // Clear the user session data (in this case, just the username)
    prefs.remove('username');

    // Navigate to the login page (Assuming your login page is named MyHomePage)
    Navigator.pushReplacement(context, MaterialPageRoute(builder: (context) => MyHomePage()));
  }

  void _onItemTapped(int index) {
      setState(() {
        _selectedIndex = index;
      });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('JomPick'),
        automaticallyImplyLeading: false, // Remove the back button
        actions: <Widget>[
          IconButton(
            icon: Icon(Icons.logout),
            onPressed: () {
              handleLogout(); // Logout when the button is pressed
            },
          ),
        ],
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            Text(
              'Welcome $username!',
              style: TextStyle(fontSize: 24),
            ),
            // Content for the selected tab
            // Add content for other tabs as needed
          ],
        ),
      ),
      bottomNavigationBar: BottomNavigationBar(
        items: const <BottomNavigationBarItem>[
          BottomNavigationBarItem(
            icon: Icon(Icons.home),
            label: 'Home',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.history),
            label: 'History',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.person),
            label: 'Profile',
          ),
        ],
        currentIndex: _selectedIndex,
        onTap: _onItemTapped,
      ),
    );
  }
}