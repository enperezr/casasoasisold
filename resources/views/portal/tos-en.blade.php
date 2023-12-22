@section('styles')
    <link rel="stylesheet" href="{{asset('css/contactus.css')}}">
@endsection
@section('description', trans('messages.app.description'))
@section('keywords', trans('messages.app.keywords'))
@extends($apk ? 'layout.apk' : 'layout.master')
@section('title', trans('messages.app.tos'))
@section('canonical')
    <link rel="canonical" href="{{Request::url()}}">
@endsection
@section('google')
    @include('portal.google-ads')
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="large-12 columns">
                @if($apk)
                <div class="block">
                    <p class="text-center">
                    <a href="{{URL::previous()}}">Back to publication</a>
                    </p>
                </div>
                @endif
                <div class="block">
                    <h1 class="title">Terms and Conditions</h1>
                    <h5>To the publisher, The person who publish his property in order to manage an operation of sale or exchange</h5>
                    <ol>
                        <li>
                            <p>
                                Your information is published according to Privacy Policy and Data Treatment described below.
                                Habana Oasis is not responsible in any way for the use that from this public information can make thirds
                                that visit the site and extract the information.
                            </p>
                        </li>
                        <li>
                            <p>
                                Habana Oasis is not responsible for the misuse of the mail service, including the sending of ofensives or harmfull messages.
                                Nevertheless we are going to make our best to avoid this from happening, or if it happens, prevent that happen again.
                            </p>
                        </li>
                        <li>
                            <p>
                                Habana Oasis will provide all the help requested from the justice system according to the current legislation, if requested
                                by this system.
                            </p>
                        </li>
                        <li>
                            <p>
                                Habana Oasis can eliminate any publication if prove that the publication is fake or a hoax is provided without
                                warning or reparation to the publisher.
                            </p>
                        </li>
                    </ol>
                    <h5>To the user seeking publications as potential client</h5>
                    <ol>
                        <li>
                            Habana Oasis does not guarantee veracity in the data from user's publications. Nevertheless any ailment
                            from a user will be taken care of as soon as posible.
                        </li>
                    </ol>
                    <h5>Besides:</h5>
                    <ol>
                        <li>
                            <p>
                                Habana Oasis will always try to provide the best service but it is imposible for alien reasons to guarantee
                                availability. In any case we will do our best to restart our service as soon as posible
                            </p>
                        </li>
                        <li>
                            <p>
                                By using the site you are aware and you have accepted all this Terms and Conditions.
                            </p>
                        </li>
                        <li>
                            <p>
                                The present Terms and Conditions can be modified by Habana Oasis at any time if needed and they will
                                be effective at the time of his publications on this page.
                            </p>
                        </li>
                    </ol>
                    <p>For any doubt in interpretation, acceptance or scope of this terms, please reach us at info@habanaoasis.com</p>
                </div>
                <div class="block">
                    <h3 class="title">Privacy Policy and Data Treatment</h3>
                    <p class="description">
                        All information you provide to <strong>Habana Oasis</strong> will be respected and protected.
                        It will never be used to ends not described by this document. Your privacy is important to us.
                        That's why we consider important that you know everything we do and we don't do with your data.
                    </p>
                    <p><strong>By using Habana Oasis you are agree with all the rules described in this document</strong></p>
                    <p>
                        We will not share to thirds your info, but in the way described in this Privacy policy.
                        Habana Oasis will reveal any information, including personal data, that is considered mandatory to fulfill legal requirements.
                    </p>
                    <h5>1. Use of the Information</h5>
                    <p>
                        Habana Oasis can use the personal data you provide without personal identification to research internal behaviour of the site,
                        like can be the gathering of statistics. This information is regarding your use of the website like the most visited pages.
                    </p>
                    <p>
                        Much of the information you provide is used according Habana Oasis mission. The data of your house is available and indexed
                        to facilitate that potential clients find your offer. All data in the form <strong>publish property</strong> are availables to all users.
                        Data in the form <strong>Operation form</strong> is public too. The data in <strong>contact data</strong> phones and names are published. <strong>Mail is not</strong>,
                        Offering you the possibility of only provide your mail and protect personal data, you then will be contacted by Habana Oasis with messages of potentials clients
                        including his/her mail address and you can then decide if answer or not.
                    </p>
                    <p>
                        You will be contacted por Habana Oasis:
                        <ul>
                            <li>When someone sends you a message through Habana Oasis.</li>
                            <li>When someone publish a comment in your publication, with the mail address of the sender.</li>
                            <li>When your accredited time is about to expire, at seven days and at three days.</li>
                            <li>Whent your accredited time is expired.</li>
                            <li>When the Habana Oasis team needs to do it. We will try to keep this cases at minimum.</li>
                        </ul>
                    </p>
                    <h5>2. Cookies and Files</h5>
                    <p>
                        Habana Oasis will put “cookies” on your hard drive to recognize you as user of the site and provide better support. You can delete the cookie at any time.
                        Or make you browser refuse this cookies automatically. Your use of the Habana Oasis site would be the same, although maybe some limitation or incorrect behaviour arise.
                    </p>
                    <p>Other services used by Habana Oasis to collect statistical data as Google Analitics, can also put "cookies" in your hard drive.</p>
                    <h5>3. Thirds</h5>
                    <p>
                        Your information will be shared with thirds:
                    <ul>
                        <li>In cases of legal requirements</li>
                        <li>To facilitate your advertising in social networks and sites like Habana Oasis, Under request you can disable this behaviour.</li>
                    </ul>
                    </p>
                    <h6>Google Analytics:</h6>
                    <p>
                        Google Analytics is an statistical service provided by Google, Inc., a Delaware company who's main office is in 1600 Amphitheatre Parkway, Mountain View (California), CA 94043, USA (“Google”).
                        Google Analytics use “cookies”, which are text files saved in your computer, to help web site managers to analyze the use of the web site for users. This information is transmitted directly to Google servers in Estados Unidos.
                        Google will use this information to help us with statistical reports, about activity in the Web Site and internet use. Google can transmit this information to thirds when
                        legal requires, or to others in order to process the information for Google. Google will not associate your IP adress with any other data it can have. You can avoid this
                        by making your browser refuse the cookies, nevertheless doing this can affect the correct behaviour of the Web site. By using this site you accept the privacy policy of Google as well for this described purposes.
                    </p>
                    <h5>5. Security</h5>
                    <p>Habana Oasis has implanted measures to protect your personal information “on line” and “off line”.</p>
                    <h5>6. Changes Notification</h5>
                    <p>
                        The present policy can be modified by Habana Oasis at any time and it will be active at the time of his publication. If you are a registered user, we will email you the new revised policy.
                    </p>
                    <p>To clarify any doubt about this policy, please email us at info@habanaoasis.com.</p>
                </div>
            </div>
        </div>
    </div>
@endsection