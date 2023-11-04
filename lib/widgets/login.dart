import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:http/http.dart' as http;
import 'package:flutter/gestures.dart'; // Add this import

import 'dashboard.dart';
import 'register.dart';


class LoginPage extends StatefulWidget {
  const LoginPage({Key? key}) : super(key: key);

  @override
  _LoginPageState createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  TextEditingController user = TextEditingController();
  TextEditingController pass = TextEditingController();

  Future login() async {
    var url = Uri.http("192.168.1.124", '/login.php', {'q': '{http}'});
    var response = await http.post(url, body: {
      "username": user.text,
      "password": pass.text,
    });
    var data = json.decode(response.body);
    if (data.toString() == "Success") {
      Fluttertoast.showToast(
        msg: 'Login Successful',
        backgroundColor: Colors.green,
        textColor: Colors.white,
        toastLength: Toast.LENGTH_SHORT,
      );
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) => DashBoard(),
        ),
      );
    } else {
      Fluttertoast.showToast(
        backgroundColor: Colors.red,
        textColor: Colors.white,
        msg: 'Username and password invalid',
        toastLength: Toast.LENGTH_SHORT,
      );
    }  }

  bool isPasswordVisible = false;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: SingleChildScrollView(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Image.asset(
                'assets/jompick.jpg', // Replace with your image path
                width: 300, // Adjust the width as needed
                height: 300, // Adjust the height as needed
              ),
              const SizedBox(height: 20),
              Text(
                'Login',
                style: TextStyle(
                  fontSize: 30,
                  fontWeight: FontWeight.bold,
                ),
              ),
              const SizedBox(height: 20),
              Padding(
                padding: const EdgeInsets.all(16.0),
                child: TextField(
                  controller: user,
                  decoration: InputDecoration(
                    labelText: 'Username',
                  ),
                ),
              ),
              Padding(
                padding: const EdgeInsets.all(16.0),
                child: TextField(
                  controller: pass,
                  obscureText: !isPasswordVisible,
                  decoration: InputDecoration(
                    labelText: 'Password',
                    suffixIcon: GestureDetector(
                      onTap: () {
                        setState(() {
                          isPasswordVisible = !isPasswordVisible;
                        });
                      },
                      child: Icon(
                        isPasswordVisible
                            ? Icons.visibility
                            : Icons.visibility_off,
                      ),
                    ),
                  ),
                ),
              ),
              RichText(
                text: TextSpan(
                  text: "Don't have an account? ",
                  style: TextStyle(
                    fontSize: 16, // You can adjust the font size as needed
                    color: Colors.black,
                  ),
                  children: <TextSpan>[
                    TextSpan(
                      text: 'Sign Up',
                      style: TextStyle(
                        fontSize: 16, // You can adjust the font size as needed
                        color: Colors.blue,
                        decoration: TextDecoration.underline, // Add underline to make it look like a link
                      ),
                      recognizer: TapGestureRecognizer()
                        ..onTap = () {
                          // Add your navigation logic here when "Sign Up" is tapped
                          Navigator.push(
                            context,
                            MaterialPageRoute(builder: (context) => const Register()),
                          );
                        },
                    ),
                  ],
                ),

              ),
              const SizedBox(height: 10),
              ElevatedButton(
                onPressed: () {
                  login();
                },
                style: ElevatedButton.styleFrom(
                  fixedSize: Size(300, 50), // Adjust the width and height as needed
                ),
                child: Text('Login', style: TextStyle(fontSize: 18)), // Adjust the font size as needed
              ),
              TextButton(
                onPressed: () {
                },
                child: Text(
                  'Forgot password',
                  style: TextStyle(
                    decoration: TextDecoration.underline, // Add underline to make it look like a link
                  ),
                ),
              ),
              const SizedBox(height: 10),
            ],
          ),
        ),
      ),
    );
  }
}
