<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        try {
            $validated = $request->validate([
                'message' => 'required|string|max:1000'
            ]);

            ChatMessage::create([
                'user_id' => Auth::id(),
                'message' => $validated['message'],
                'sender_type' => 'user',
                'is_read' => false
            ]);

            $response = $this->generateAIResponse($validated['message']);

            ChatMessage::create([
                'user_id' => Auth::id(),
                'message' => $response,
                'sender_type' => 'bot',
                'is_read' => true
            ]);

            return response()->json([
                'success' => true,
                'response' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('Chat error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'response' => 'I apologize, but I encountered an issue. Please try again or contact our support team.'
            ], 200);
        }
    }

    private function generateAIResponse($message)
    {
        $message = strtolower(trim($message));

        $responses = [
            'hello' => "Hello! 👋 Welcome to Taakra! I'm here to help you with competitions, registrations, and more. What would you like to know?",
            'hi' => "Hi there! 😊 How can I assist you today? Feel free to ask about competitions, registration process, or anything else!",
            'hey' => "Hey! 🎉 Great to see you! What can I help you with?",
            'register' => "To register for a competition:\n1. Browse competitions\n2. Click on one that interests you\n3. Click 'Register Now'\n4. Wait for admin approval (usually 24-48 hours)\n5. You'll receive a confirmation!",
            'deadline' => "Each competition has its own registration deadline shown on the competition detail page. Make sure to register before the deadline! You can also view all deadlines in the calendar view.",
            'fee' => "Competition entry fees vary:\n• Some are completely FREE 🎉\n• Others may have a small entry fee\n• Check each competition's detail page for exact pricing",
            'category' => "We have competitions in multiple categories:\n🏆 Sports\n💻 Technology\n🎨 Arts & Design\n💼 Business\n📚 Education\nAnd many more! Use filters to find your interest.",
            'status' => "To check your registration status:\n1. Go to 'My Competitions'\n2. You'll see: Pending ⏳, Confirmed ✅, or Rejected ❌\nAdmins typically review within 24-48 hours.",
            'help' => "I can help you with:\n• Competition information\n• Registration process\n• Deadlines and fees\n• Categories\n• Status tracking\n• General questions\n\nYou can also connect with our live support team!",
            'support' => "Need human assistance? Our support team is here for you! Click the 'Connect to Support' button to chat with a real person. Available 24/7! 💬",
            'prize' => "Prizes vary by competition and may include:\n💰 Cash rewards\n🏆 Trophies & certificates\n🎁 Gift cards\n🌟 Recognition & exposure\nCheck each competition's prize section for details!",
            'how' => "Getting started is easy:\n1. Create a free account\n2. Browse competitions\n3. Register for ones you like\n4. Participate and win!\nIt's that simple! 🚀"
        ];

        foreach ($responses as $keyword => $reply) {
            if (str_contains($message, $keyword)) {
                return $reply;
            }
        }

        if (str_contains($message, '?')) {
            return "That's a great question! 🤔 I can help you with information about:\n• Competitions and categories\n• Registration process\n• Deadlines and fees\n• Your registration status\n• Prize information\n\nWhat specifically would you like to know?";
        }

        return "Thanks for reaching out! 😊 I'm here to help with competitions, registrations, and more. You can ask me about:\n• How to register\n• Competition categories\n• Deadlines and fees\n• Your registration status\n\nOr connect with our support team for detailed assistance!";
    }

    public function getHistory()
    {
        try {
            $messages = ChatMessage::where('user_id', Auth::id())
                ->latest()
                ->take(50)
                ->get()
                ->reverse()
                ->values();

            return response()->json([
                'success' => true,
                'messages' => $messages
            ]);
        } catch (\Exception $e) {
            Log::error('Chat history error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'messages' => []
            ]);
        }
    }

    public function connectToSupport(Request $request)
    {
        try {
            $validated = $request->validate([
                'message' => 'required|string|max:1000'
            ]);

            ChatMessage::create([
                'user_id' => Auth::id(),
                'message' => $validated['message'],
                'sender_type' => 'user',
                'support_id' => null,
                'is_read' => false
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Connected to support team! A support agent will respond shortly.'
            ]);
        } catch (\Exception $e) {
            Log::error('Support connection error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unable to connect. Please try again.'
            ]);
        }
    }
}
