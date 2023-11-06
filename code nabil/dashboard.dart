import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

import '../models/user.dart';

void main() => runApp(MaterialApp(home: DashBoard()));

class DashBoard extends StatefulWidget {
  @override
  _DashBoardState createState() => _DashBoardState();
}

class _DashBoardState extends State<DashBoard> {
  int _selectedIndex = 0;
  List<User> users = [];

  @override
  void initState() {
    super.initState();
    fetchUserData();
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
  void _onItemTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      home: Scaffold(
        appBar: AppBar(
          title: Text('JomPick', style:TextStyle(fontSize: 24)),
          backgroundColor: Colors.blue,
        ),
        body:Center(
          child: Padding(
            padding: const EdgeInsets.all(5.0),
            // Add padding to all sides
            child: users.isEmpty
                ? CircularProgressIndicator()
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
                            Column(
                              children: <Widget>[

                                ListTile(
                                  leading: Text("Date", style: TextStyle(color: Colors.grey.withOpacity(0.5)),),
                                  horizontalTitleGap: 10,
                                  trailing: Text("Time", style: TextStyle(color: Colors.grey.withOpacity(0.5)),),
                                ),],
                            ),
                            Row(
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
          ),
        ),

        bottomNavigationBar: BottomNavigationBar(
          type : BottomNavigationBarType.fixed,
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






