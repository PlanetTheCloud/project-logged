<?php

define('APP', dirname(__FILE__));
require APP.'/app/config.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title><?=$final['title']['terms'];?> - <?=$final['company_name'];?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <link href="/auth/assets/style.css" rel="stylesheet">
    </head>
    <body class="login-page" style="max-width: 750px!important;">
        <div class="login-box">
            <a href="<?=$final['main_site'];?>">
                <p style="text-align:center">
                  <img src="<?=$final['logo'];?>" alt="<?=$final['company_name'];?> logo"/>
                </p>
            </a>
            <div class="card">
                <div class="body">
                    <div class="msg"><?=$final['msg']['terms'];?></div>

                    <h4>1. ACCEPTANCE OF TERMS</h4>
                    <p>{$c} welcomes you.</p>
                    <p>{$c} provides its service to you subject to the following Terms of Service ("TOS"), which may be updated by us from time to time without notice to you. You can review the most current version of the TOS at any time at: <a href="{this_page}">{your_domain}{path_to_terms</a>. In addition, when using particular {$c} owned or operated services, you and {$c} shall be subject to any posted guidelines or rules applicable to such services, which may be posted from time to time. All such guidelines or rules (including but not limited to our Spam Policy) are hereby incorporated by reference into the TOS. {$c} may also offer other services that are governed by different Terms of Service.</p>

                    <br/>

                    <h4>2. DESCRIPTION OF SERVICE</h4>
                    <p>{$c} provides users with access to a rich collection of resources, including various communications tools, forums, shopping services, search services, personalized content and branded programming through its network of properties which may be accessed through any various medium or device now known or hereafter developed (the "Service"). You also understand and agree that the Service may include advertisements and that these advertisements are necessary for {$c} or it's Partners to provide the Service. You also understand and agree that the Service may include certain communications from {$c} or it's Partners, such as service announcements, administrative messages and the {$c} Newsletter, and that these communications are considered part of {$c} membership and you will not be able to opt out of receiving them. Unless explicitly stated otherwise, any new features that augment or enhance the current Service, including the release of new {$c} properties, shall be subject to the TOS. You understand and agree that the Service is provided "AS-IS" and that {$c} assumes no responsibility for the timeliness, deletion, mis-delivery or failure to store any user communications or personalization settings. You are responsible for obtaining access to the Service, and that access may involve third-party fees (such as Internet service provider or airtime charges). You are responsible for those fees, including those fees associated with the display or delivery of advertisements. In addition, you must provide and are responsible for all equipment necessary to access the Service.</p>

                    <br/>

                    <h4>3. YOUR REGISTRATION OBLIGATIONS</h4>
                    <p>In consideration of your use of the Service, you represent that you are of legal age to form a binding contract and are not a person barred from receiving services under the laws of the United States or other applicable jurisdiction. You also agree to:</p>
                    <p>(a) provide true, accurate, current and complete information about yourself as prompted by the Service's registration form (the "Registration Data") and</p>
                    <p>(b) maintain and promptly update the Registration Data to keep it true, accurate, current and complete. If you provide any information that is untrue, inaccurate, not current or incomplete, or {$c} has reasonable grounds to suspect that such information is untrue, inaccurate, not current or incomplete, {$c} has the right to suspend or terminate your account and refuse any and all current or future use of the Service (or any portion thereof).</p>
                    <p>{$c} is concerned about the safety and privacy of all its users, particularly children. Please remember that the Service is designed to appeal to a broad audience. Accordingly, as the legal guardian, it is your responsibility to determine whether any of the Service areas and/or Content (as defined in Section 6 below) are appropriate for your child.</p>

                    <br/>

                    <h4>4. {$c_caps} PRIVACY POLICY</h4> 
                    <p>Registration Data and certain other information about you is subject to our Privacy Policy. For more information, see our full privacy policy at <a href="{link_to_privacy}">{privacy}</a> , You understand that through your use of the Service you consent to the collection and use (as set forth in the Privacy Policy) of this information, including the transfer of this information to the United States and/or other countries for storage, processing and use by {$c} and its affiliates.</p>

                    <br/>

                    <h4>5. MEMBER ACCOUNT, PASSWORD AND SECURITY</h4>
                    <p>You will receive a password and account designation upon completing the Service's registration process. You are responsible for maintaining the confidentiality of the password and account and are fully responsible for all activities that occur under your password or account. You agree to :</p>
                    <ul>
                        <li>immediately notify {$c} of any unauthorized use of your password or account or any other breach of security, and</li>
                        <li>ensure that you exit from your account at the end of each session. {$c} cannot and will not be liable for any loss or damage arising from your failure to comply with this Section 5.</li>
                    </ul>

                    <br/>

                    <h4>6. MEMBER CONDUCT</h4>
                    <p>You understand that all information, data, text, software, music, sound, photographs, graphics, video, messages, tags, or other materials ("Content"), whether publicly posted or privately transmitted, are the sole responsibility of the person from whom such Content originated. This means that you, and not {$c}, are entirely responsible for all Content that you upload, post, email, transmit or otherwise make available via the Service. {$c} does not control the Content posted via the Service and, as such, does not guarantee the accuracy, integrity or quality of such Content. You understand that by using the Service, you may be exposed to Content that is offensive, pornographic, indecent or objectionable. Under no circumstances will {$c} be liable in any way for any Content, including, but not limited to, any errors or omissions in any Content, or any loss or damage of any kind incurred as a result of the use of any Content posted, emailed, transmitted or otherwise made available via the Service.</p>

                    <br/>
                    <!-- SOMEONE SHOULD FIX THE TERMS!!!! -->
                    <h4>YOU AGREE TO NOT USE THE SERVICE TO</h4>
                    <ol>
                        <li>upload, post, email, transmit or otherwise make available any Content that is unlawful, harmful, threatening, abusive, harassing, tortious, defamatory, vulgar, obscene, libelous, invasive of another's privacy, hateful, or racially, ethnically or otherwise objectionable;</li>
                        <li>harm minors in any way;</li>
                        <li>impersonate any person or entity, including, but not limited to, a {$c} official, forum leader, guide or host or falsely state or otherwise misrepresent your affiliation with a person or entity;</li>
                        <li>forge headers or otherwise manipulate identifiers in order to disguise the origin of any Content transmitted through the Service;</li>
                        <li>upload, post, email, transmit or otherwise make available any Content that you do not have a right to make available under any law or under contractual or fiduciary relationships (such as inside information, proprietary and confidential information learned or disclosed as part of employment relationships or under nondisclosure agreements);</li>
                        <li>upload, post, email, transmit or otherwise make available any Content that infringes any patent, trademark, trade secret, copyright or other proprietary rights ("Rights") of any party; This includes linking to or redirecting to any content or copyright files hosted on a 3rd party resource / servers.</li>
                        <li>upload, post, email, transmit or otherwise make available any unsolicited or unauthorized advertising, promotional materials, "junk mail," "spam," "chain letters," "pyramid schemes," or any other form of solicitation, except in those areas (such as shopping) that are designated for such purpose;</li>
                        <li>upload, post, email, transmit or otherwise make available any material that contains software viruses or any other computer code, files or programs designed to interrupt, destroy or limit the functionality of any computer software or hardware or telecommunications equipment;</li>
                        <li>upload, post, email, transmit or otherwise make available any material that is of broadcast / streaming types.</li>
                        <li>upload, post, email, transmit or otherwise make available any material that is of keylogging / proxy service / irc / shell(s) if any type / file hosting / file sharing types.</li>
                        <li>upload, post, email, transmit or otherwise make available any material on free hosting accounts that is of pornographic nature.</li>
                        <li>interfere with or disrupt the Service or servers or networks connected to the Service, or disobey any requirements, procedures, policies or regulations of networks connected to the Service;</li>
                        <li>intentionally or unintentionally violate any applicable local, state, national or international law, including, but not limited to, regulations promulgated by the U.S. Securities and Exchange Commission, any rules of any national or other securities exchange, including, without limitation, the New York Stock Exchange, the American Stock Exchange or the NASDAQ, and any regulations having the force of law;</li>
                        <li>provide material support or resources (or to conceal or disguise the nature, location, source, or ownership of material support or resources) to any organization(s) designated by the United States government as a foreign terrorist organization pursuant to section 219 of the Immigration and Nationality Act;</li>
                        <li>"stalk" or otherwise harass another; and/or</li>
                        <li>upload, post, email, transmit or otherwise material for the purposes of file distribution, relay, or streaming reasons.</li>
                        <li>collect or store personal data about other users in connection with the prohibited conduct and activities set forth in paragraphs 1 through 15 above.</li>
                    </ol>

                    <br/>

                    <h4>7. USE OF COPYRIGHT MATERIAL AND PROOF OF OWNERSHIP OF CONTENT</h4>
                    <p>Sites must not contain Warez, copyright or other illegal material including links or redirects to copyright material hosted on 3rd party websites / resources. The onus is on you the customer to prove that you own the rights to publish material, not for {$c} to prove that you do not. {$c} does not allow the propagation or distribution of copyright material, files or warez under any circumstances.</p>

                    <br/>

                    <h4>8. ACCEPTABLE SERVER RESOURCE USE</h4>
                    <p>Sites must not use excessive amounts of server resources. These include bandwidth, processor utilization and / or disk space. Please see the 'High Resource Use Policy' in the General Terms and Conditions.</p>

                    <br/>

                    <h4>9. BACKUPS / REQUESTING DATA BACKUP</h4>
                    <p>It is the client / account holders responsibility to maintain and keep backups of website and MySQL data. We do not provide data restores from our archives / restoring a website or database to an earlier version. We also do not provide free backups / archives of customers own current data. We reserve the right to charge a fee of 14.99 USD if we are requested to create a backup on a customers behalf. We may choose to waive this fee under circumstances of our choosing.</p>

                    <br/>

                    <h4>10. SCRIPT USAGE TERMS</h4>
                    <p>Scripts on the site must be designed to produce web-based content, and not to use the server as an application server. Using the server to generate large volumes of email from a database is an example of activity that is not allowed. Scripts should not attempt to manipulate the timeouts on servers. These are set at the present values to ensure the reliability of the server. Sites that reset these do so because they are resource intensive, and adversely affect server performance and are therefore not allowed. Scripts that are designed to provide proxy services, anonymous or otherwise, are not allowed.</p>
                    <p>The primary purpose of any script must be to produce a web page. Scripts that send a single email based upon user entered information, or update a database are acceptable. Scripts that send bulk email or perform processor intensive database processes are not allowed. All outgoing mail is monitored and filtered and must be sent to or from a {$c}-hosted domain.</p>
                    <p>Sites must not contain scripts that attempt to access privileged server resources, or other sites on the same server</p>
                    <p>Examples of not allowed script and website types include (but are not limited to):</p>
                    <ol>
                        <li>Pornographic/adult content</li>
                        <li>Proxy scripts</li>
                        <li>Chat scripts</li>
                        <li>Bitcoin / cryptocurrency faucet sites</li>
                        <li>File sharing / file storage scripts</li>
                        <li>Autolike scripts</li>
                        <li>Hacking scripts / PHP shell scripts</li>
                        <li>Phishing</li>
                        <li>Mass mail scripts</li>
                        <li>Website scraping/crawling/downloading scripts</li>
                        <li>Torrents</li>
                        <li>Warez</li>
                        <li>Cracked/pirated content of any kind</li>
                    </ol>

                    <br/>

                    <h4>11. USAGE OF DISK SPACE TERMS</h4>
                    <p>{$c} offers large web space and bandwidth with hosting accounts. By this, we mean space for legitimate web site content and bandwidth for visitors to view it. All files on a domain must be part of the active website and linked to the site. Sites should not contain any backups, downloads, or other non-web based content. We will treat all password protected archive (e.g. zip and rar) files as unacceptable. Multimedia content such as audio and video is acceptable provided it is streamed to the user, links to HTTP download of this content is not acceptable.</p>
                    <p>Archives of movie files, audio files, zips, rars or any large volumes of files used for downloading / sharing is not allowed.</p>

                    <script src="/auth/assets/material.js"></script>
                </div>
            </div>
        </div>
    </body>
</html>