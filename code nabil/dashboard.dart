import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

import 'penalty.dart';
import 'profile.dart';
import 'setting.dart';
import '../models/user.dart';

void main() => runApp(MaterialApp(home: DashBoard()));

class DashBoard extends StatefulWidget {
  @override
  _DashBoardState createState() => _DashBoardState();
}

class _DashBoardState extends State<DashBoard> {
  int _selectedPage = 0;
  List<User> users = [];
  String? username = '';


  @override
  void initState() {
    super.initState();
    fetchUserData();
    loadUsername();
  }

  Future<void> loadUsername() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    setState(() {
      username = prefs.getString('username');
    });
  }
  void handleSetting() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();

    // Navigate to the login page (Assuming your login page is named Setting)
    Navigator.pushReplacement(context, MaterialPageRoute(builder: (context) => Setting()));
  }

  Future<void> fetchUserData() async {
    final response = await http.get(Uri.parse('http://10.200.118.238/read.php'));

    if (response.statusCode == 200) {
      final List<dynamic> data = json.decode(response.body);
      setState(() {
        users = data.map((item) => User.fromJson(item)).toList();
      });
    } else {
      throw Exception('Failed to load user data');
    }
  }

  void _detailsUser(int index) {
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (context) => DetailsScreen(
          details: users[index],
        ),
      ),
    );
  }

  void _onItemTapped(int page) {
    if (page == 3) {
      // If the "Profile" button is tapped (index 3), navigate to the profile page
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) => Profile(), // Replace "ProfilePage()" with the actual profile page widget
        ),
      );
    } else if(page == 2) {
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) =>
              Penalty(), // Replace "Penalty()" with the actual profile page widget
        ),
      );
    } else if(page == 1) {
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) =>
              Setting(), // Replace "Setting()" with the actual profile page widget
        ),
      );
    } else{
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) =>
              DashBoard(), // Replace "DashBoardPage()" with the actual profile page widget
        ),
      );
      setState(() {
        _selectedPage = page;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('JomPick'),
        automaticallyImplyLeading: false, // Remove the back button
        actions: <Widget>[
          IconButton(
            icon: Icon(Icons.settings),
            onPressed: () {
              handleSetting(); // Logout when the button is pressed
            },
          ),
        ],
      ),

        body: Column(
              children: [
                Text(
                  'Welcome $username!',
                  style: TextStyle(fontSize: 24),
                ),
                Padding(
                  padding: const EdgeInsets.all(20.0),
                  child: TextField(
                    decoration: InputDecoration(
                      hintText: 'Search',
                      prefixIcon: Icon(Icons.search),
                      filled: true,
                      fillColor: Colors.white10, // Set the background color to grey
                      border: OutlineInputBorder( // Use OutlineInputBorder for border
                        borderSide: BorderSide(color: Colors.white12), // Set the border color to grey
                        borderRadius: BorderRadius.circular(10.0), // Adjust the border radius as needed
                      ),
                    ),
                  ),
                ),

                Container(
                child: _buildListView(),
                ),
              ]
        ),

        bottomNavigationBar: BottomNavigationBar(
          type: BottomNavigationBarType.fixed,
          items: const <BottomNavigationBarItem>[
            BottomNavigationBarItem(
              icon: Icon(Icons.home),
              label: 'Home',
            ),
            BottomNavigationBarItem(
              icon: Icon(Icons.settings),
              label: 'settings',
            ),
            BottomNavigationBarItem(
              icon: Icon(Icons.error),
              label: 'Penalty',
            ),
            BottomNavigationBarItem(
              icon: Icon(Icons.person),
              label: 'Profile',
            ),
          ],
          currentIndex: _selectedPage,
          onTap: _onItemTapped,
        ),
      );
  }

  Widget _buildListView(){
    return Expanded(
      child: users.isEmpty
          ? const CircularProgressIndicator()
          :  Center(
        child: Scrollbar(
          child:ListView.builder(
            itemCount: users.length,
            itemBuilder: (context, index) {
              return  Card(
                margin: EdgeInsets.all(8.0),
                child: Padding(
                  padding: EdgeInsets.only(bottom: 15.0),
                  child:Column(
                    mainAxisSize: MainAxisSize.min,
                    children: <Widget>[
                      ListTile(
                        leading: Image.asset(
                          'assets/jompick.jpg', // Replace with your image path
                          width: 90, // Adjust the width as needed
                          height: 90, // Adjust the height as needed
                        ),
                        title: Text(users[index].fullName),
                        subtitle: Text(users[index].emailAddress),
                      ),
                      Divider(
                        height: 20.0,
                        thickness: 1.0,
                        color: Colors.grey.withOpacity(0.5),
                        indent: 15.0,
                        endIndent: 15.0,
                      ),
                      ListTile(
                        leading: Text(
                            "Time", style: TextStyle(color: Colors.grey.withOpacity(0.5)),
                        ),
                        trailing: Text(
                            "Date", style: TextStyle(color: Colors.grey.withOpacity(0.5)),
                        ),

                      ),
                      Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: <Widget>[
                          ElevatedButton(
                            onPressed: () {
                              _detailsUser(index);
                            },
                            style: ElevatedButton.styleFrom(
                              fixedSize: Size(340, 45),
                              shape: RoundedRectangleBorder(
                                borderRadius: BorderRadius.circular(100),
                              ),// Adjust the width and height as needed
                            ),
                            child: Text('Details', style: TextStyle(fontSize: 16)), // Adjust the font size as needed
                          ),
                        ],
                      ),

                    ],
                  ),
                ),

              );},
          ),
        ),
      ),
    );
  }
}

class DetailsScreen extends StatelessWidget{
  final List<User> users = [];
  final User details;

  DetailsScreen({required this.details});


  // Widget build method and user interface (UI) goes here
  @override
  Widget build(BuildContext context){
    // Initialize the controllers with the current expense details

    return MaterialApp(
      theme: ThemeData(
          colorSchemeSeed: const Color(0xffffffff), useMaterial3: true),
        home: Scaffold(
          appBar: AppBar(
            title: Text('User Details'),
            leading: IconButton(
              icon: Icon(Icons.arrow_back),
              onPressed: () {
                Navigator.pop(context); // Redirects to the previous page (login page)
              },
            ),
          ),
          body:Row(
              children: [
                  Column(
                    children: [
                      Padding(
                        padding: const EdgeInsets.all(16.0),
                        child: Text('Phone Number: ${details.phoneNumber}'),
                      ),
                    ],
                  ),
                ],
              ),
          ),
    );
  }
}






