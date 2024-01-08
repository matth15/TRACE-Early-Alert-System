<?php



class Templates
{

  /**
   * Construct the body of contact email
   *
   */
  public static function getOtpLoginBody($data)
  {

    // You patse your HTML email template in the ''
    $body  = ' 
              <p>Someone who knows your password is attempting to sign-in to your TRACE Early Alert web account.</p>
              <p>If this was you, your verification code is:</p>
              <h3><b>' . $data["otp"] . '</b></h3>
              <p>Don’t share it with others.</p>
    ';
    return $body;
  }

  //
  public static function getAccountVerifiedBody($data)
  {

    $body = '
    
             <p>Your TRACE Email ' . $data["email"] . ' has Successfully Verified to</p>
             <p>TRACE College Early Alert System. You can now access ' . $data["user_type"] . '</p> 
             <p> dashboard. </p>
    
    ';
    return $body;
  }
  //
  public static function getOtpForgotPasswordBody($data)
  {
    $body  = ' 
    
    <p>Hi '.$data["name"].',</p>
    <p>We received a request to reset the password for your account in TRACE Early Alert</p>
    <p>Get the code to reset your password: </p>
    <h3><b>' . $data["otp"] . '</b></h3>
    <p>Don’t share it with others.</p>
';
return $body;
  }
//   public function getEarlyAlertPdf($data){
//     $pdf = new TCPDF();

// // Set document properties
// $pdf->SetCreator(PDF_CREATOR);
// $pdf->SetAuthor('Your Name');
// $pdf->SetTitle('2nd Quarter Early Alert');
// $pdf->SetSubject('Subject');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// // Add a page
// $pdf->AddPage();

// // Set font
// $pdf->SetFont('helvetica', '', 11);

// // Add content to the PDF
// $pdf->Cell(0, 10, 'IMAGE-LOGO', 0, 1, 'C');
// $pdf->Ln(4);

// $pdf->Cell(0, 10, '2nd Quarter Early alert', 0, 1, 'C');
// $pdf->Ln(3);

// $pdf->Cell(0, 10, 'December 04, 2023', 0, 1, 'L');
// $pdf->Ln(3);

// $pdf->MultiCell(0, 10, 'Dear Parents,', 0, 'L');
// $pdf->Ln(3);

// $pdf->MultiCell(0, 10, 'Greetings of peace!', 0, 'L');
// $pdf->Ln(2);

// // Replace these variables with your actual values
// $variableName = 'John Doe';
// $variableGrade = '10';
// $variableSubject1 = 'Math';
// $variableSubject2 = 'English';

// $pdf->MultiCell(0, 10, "We would like to inform you that your child $variableName, Grade $variableGrade, obtained scores in his/her academic tasks in the following subjects that are consistently below expectations:", 0, 'L');
// $pdf->Ln(4);


// $variableSubjects = [
//     'PE 2', 'EAPP', 'Science', 'History', 'Geography',
//     'Art', 'Music', 'Physical Education', 'Computer Science', 'Foreign Language'
// ];

// // Set initial position
// $x = 10;
// $y = 88;

// // Set cell dimensions
// $cellWidth = 80;
// $cellHeight = 6;

// // Subjects 5 rows x 2 columns
// for ($row = 0; $row < 5; $row++) {
//     for ($col = 0; $col < 2; $col++) {
//         // Calculate index in the variableSubjects array
//         $index = $row * 2 + $col;

//         // Check if there are more subjects
//         if ($index < count($variableSubjects)) {
//             // Set position for the current cell
//             $pdf->SetXY($x + $col * $cellWidth, $y + $row * $cellHeight);

//             // Add the subject to the current cell
//             $subjectText = ($index + 1) . ". " . $variableSubjects[$index] . "";
//             $pdf->MultiCell($cellWidth, $cellHeight, $subjectText, 0, 'L'); // 0 for no border
//         }
//     }
// }
// $pdf->Ln(3);



// $pdf->MultiCell(0, 10, 'As such, we would like to seek your cooperation in helping and guiding your child to improve his/her academic performance.', 0, 'L');
// $pdf->Ln(3);

// $pdf->MultiCell(0, 10, 'Also, kindly remind him/her to refrain from being absent and tardy in class as this greatly affects his/her academic performance.', 0, 'L');
// $pdf->Ln(3);

// $pdf->MultiCell(0, 10, 'Thank you very much for your usual cooperation.', 0, 'L');

// // Output the PDF to the browser or save it to a file
// $pdf->Output('example.pdf', 'I');  // 'I' to send the file inline to the browser
//   }
 }
