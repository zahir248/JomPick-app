class User {
  final String fullName;
  final String emailAddress;
  final String phoneNumber;

  User({
    required this.fullName,
    required this.emailAddress,
    required this.phoneNumber,
  });

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      fullName: json['fullName'],
      emailAddress: json['emailAddress'],
      phoneNumber: json['phoneNumber'],
    );
  }
}
